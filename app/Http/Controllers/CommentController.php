<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;

use App\Http\Resources\CommentResource;

use App\Models\Blog;
use App\Models\Comment;

use Auth;


class CommentController extends Controller
{
    public function show($id)
    {
        $comments = Comment::where('blog_id',$id)->get();
        return new CommentResource($comments);
       
    }
    public function store(CommentCreateRequest $request)
    {
        $validated = $request->validated();

        $user_id = Auth::id();
        $comment = Comment::create([
            'content' => $request->content,
            'blog_id' => $request->blog_id,
            'user_id' => $user_id,
        ]);

        return (new CommentResource($comment))
            ->additional(['message' => 'Comment created successfully']);
    }

    public function update(CommentUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $comment = Comment::findOrFail($id);
        if ($comment->user_id === Auth::id()) {
            $comment->update($request->all());
            return (new CommentResource($comment))
            ->additional(['message' => 'Comment updated successfully']);
        } else {
            return response()->json(['message' => 'You are not owner of this Comment'], 201);
        }
        
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id === Auth::id()) {
            $comment->forceDelete();
            return response()->json(['message' => 'Comment deleted successfully'], 201);
        } else {
            return response()->json(['message' => 'You are not owner of this comment'], 201);
        }
       
    }
}
