<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Requests\BlogTagCreateRequest;

use App\Http\Resources\TagResource;
use App\Http\Resources\BlogTagResource;
use Illuminate\Http\Request;

use Auth;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\BlogTag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return new TagResource($tag);
    }

    public function store(TagCreateRequest $request)
    {
        $validated = $request->validated();
        $tag = Tag::create([
            'name' => $request->name,
        ]);

        return (new TagResource($tag))
            ->additional(['message' => 'Tag created successfully']);
        
    }

    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);
        if ($tag->user_id === Auth::id()) {
            $validated = $request->validated();
            $tag->update($request->all());
            return (new TagResource($tag))
            ->additional(['message' => 'Tag updated successfully']);
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

    public function storeBlogTag(BlogTagCreateRequest $request) {
        $validated = $request->validated();
        $blogtag = BlogTag::create([
            'blog_id' => $request->blog_id,
            'tag_id' => $request->tag_id
        ]);
        return (new BlogTagResource($blogtag))
            ->additional(['message' => 'BlogTag created successfully']);
    }
}
