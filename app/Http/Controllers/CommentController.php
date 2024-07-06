<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Blog;
use App\Models\Comment;

use Auth;

class CommentController extends Controller
{
    public function show($id)
    {
        $comments = Comment::where('blog_id',$id)->get();
        return response()->json($comments);
       
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'blog_id' => 'required|exists:blogs,id'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_id = Auth::id();
        $user = Comment::create([
            'content' => $request->content,
            'blog_id' => $request->blog_id,
            'user_id' => $user_id,
        ]);

        return response()->json(['message' => 'comment created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id === Auth::id()) {
            $request->validate([
                'content' => 'required|string',
                'blog_id' => 'required|exists:blogs,id'
            ]);
            $comment->update($request->all());
            return response()->json($comment);
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
