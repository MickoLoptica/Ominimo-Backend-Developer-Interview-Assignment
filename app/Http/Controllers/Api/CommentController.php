<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request,$postId)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $request->validate([
            'content'=>'required|string'
        ]);

        $comment = Comment::create([
            'post_id'=>$postId,
            'user_id'=>$user->id,
            'content'=>$request->content,
            'is_flagged'=>false
        ]);

        return response()->json($comment,201);
    }

    public function destroy(Request $request,$id)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $comment = Comment::findOrFail($id);

        if($comment->user_id !== $user->id && $user->role !== 'admin' && $user->role !== 'moderator'){
            abort(403);
        }

        $comment->delete();

        return response()->json(['message'=>'Deleted']);
    }

    public function flag(Request $request,$id)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $comment = Comment::findOrFail($id);

        if($user->role !== 'admin' && $user->role !== 'moderator'){
            abort(403);
        }

        $comment->update(['is_flagged'=>true]);

        return response()->json($comment);
    }

    public function unflag(Request $request,$id)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $comment = Comment::findOrFail($id);

        if($user->role !== 'admin' && $user->role !== 'moderator'){
            abort(403);
        }

        $comment->update(['is_flagged'=>false]);

        return response()->json($comment);
    }
}