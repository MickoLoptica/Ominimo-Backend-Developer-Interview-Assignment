<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\RiskAssessmentService;
use App\Jobs\CalculatePostRiskJob;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(
            Post::with(['user','comments','tags'])
                ->withCount('comments')
                ->latest()
                ->paginate(request('per_page',10))
        );
    }

    public function show($id)
    {
        $post = Post::with(['user','comments','tags'])->findOrFail($id);
        return response()->json($post);
    }

    public function store(StorePostRequest $request)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $post = Post::create([
            'user_id'=>$user->id,
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        CalculatePostRiskJob::dispatch($post);

        return response()->json($post,201);
    }

    public function update(UpdatePostRequest $request,$id)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $post = Post::findOrFail($id);

        if($post->user_id !== $user->id) abort(403);

        $post->update([
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        return response()->json($post);
    }

    public function destroy(Request $request,$id)
    {
        $user = $request->user();
        if(!$user) abort(401);

        $post = Post::findOrFail($id);

        if($post->user_id !== $user->id) abort(403);

        $post->delete();

        return response()->json(['message'=>'Deleted']);
    }
}