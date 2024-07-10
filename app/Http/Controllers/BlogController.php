<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlogCreateRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Resources\BlogResource;

use Auth;
use Carbon\Carbon;

use App\Models\Blog;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('tags')->get();
        return new BlogResource($blogs);
    }

    public function store(BlogCreateRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::id();
        $posted_at =  Carbon::now();
        $blog = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'image'=>$request->image,
            'posted_at' => $posted_at,
            'user_id' => $user_id
        ]);

        return (new BlogResource($blog))
        ->additional(['message' => 'Blog created successfully']);
    }

    public function show($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }

        return new BlogResource($blog);
       
    }

    public function update(BlogUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $blog = Blog::findOrFail($id);
        if ($blog->user_id === Auth::id()) {
            $blog->update($request->all());
            // Sync tags if provided
            if ($request->has('tags')) {
                $blog->tags()->sync($request->tags);
            } else {
                $blog->tags()->detach();
            }
    
            return (new BlogResource($blog))
            ->additional(['message' => 'Blog updated successfully']);
        } else {
            return response()->json(['message' => 'You are not owner of this blog'], 201);
        }
        
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        // $comment = Comment::where('blog_id',$blog['id'])->get();
        if ($blog->user_id === Auth::id()) {
            $blog->tags()->detach();
            $blog->delete();
            // if($comment) {
            //     $comment->softDeletes($column = 'deleted_at', $precision = 0);
            // }
            return response()->json(['message' => 'Blog deleted successfully'], 201);
        } else {
            return response()->json(['message' => 'You are not owner of this blog'], 201);
        }
       
    }
}
