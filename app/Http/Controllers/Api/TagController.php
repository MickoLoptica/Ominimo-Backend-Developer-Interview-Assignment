<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string|unique:tags,name']);

        $tag = Tag::create(['name'=>$request->name]);

        return response()->json($tag,201);
    }

    public function attach(Request $request,$postId)
    {
        $post = Post::findOrFail($postId);

        $post->tags()->syncWithoutDetaching($request->tags);

        return response()->json($post->load('tags'));
    }

    public function detach(Request $request,$postId)
    {
        $post = Post::findOrFail($postId);

        $post->tags()->detach($request->tags);

        return response()->json($post->load('tags'));
    }
}