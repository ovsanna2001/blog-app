<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\BlogTag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $tag = Tag::create([
            'name' => $request->name,
        ]);


        return response()->json(['message' => 'Tag created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        if ($tag->user_id === Auth::id()) {
            $request->validate([
                'name' => 'required'
            ]);
            $tag->update($request->all());
            return response()->json($blog);
        } else {
            return response()->json(['message' => 'You are not owner of this tag'], 201);
        }
        
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return response()->json(['message' => 'Tag deleted successfully'], 201);
       
       
    }

    public function storeBlogTag(Request $request) {
        $validator = Validator::make($request->all(), [
            'blog_id' => 'required|exists:blogs,id',
            'tag_id' => 'required|exists:tags,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $tag = BlogTag::create([
            'blog_id' => $request->blog_id,
            'tag_id' => $request->tag_id
        ]);
        return response()->json(['message' => 'Blog tag created successfully'], 201);

    }
}
