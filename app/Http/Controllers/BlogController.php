<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Carbon\Carbon;

use App\Models\Blog;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->get();
        return response()->json($blogs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_id = Auth::id();
        $posted_at =  Carbon::now();
        $user = Blog::create([
            'title' => $request->title,
            'description' => $request->description,
            'image'=>$request->image,
            'posted_at' => $posted_at,
            'user_id' => $user_id
        ]);

        return response()->json(['message' => 'Blog created successfully'], 201);
    }

    public function show($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }

        return response()->json($blog);
       
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id === Auth::id()) {
            $request->validate([
                'image' => 'required',
                'title' => 'required',
                'description' => 'required',
            ]);
            $blog->update($request->all());
            // Sync tags if provided
            if ($request->has('tags')) {
                $blog->tags()->sync($request->tags);
            } else {
                $blog->tags()->detach();
            }
    
            return response()->json($blog);
        } else {
            return response()->json(['message' => 'You are not owner of this blog'], 201);
        }
        
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->user_id === Auth::id()) {
            $blog->tags()->detach();
            $comment = Comment::where('blog_id',$id)->get();
            $blog->delete();
            $comment->delete();
            return response()->json(['message' => 'Blog deleted successfully'], 201);
        } else {
            return response()->json(['message' => 'You are not owner of this blog'], 201);
        }
       
    }
}
