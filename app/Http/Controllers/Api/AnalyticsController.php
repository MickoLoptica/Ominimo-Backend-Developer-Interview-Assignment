<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Models\Tag;

class AnalyticsController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_posts'=>Post::count(),
            'total_comments'=>Comment::count(),
            'avg_comments_per_post'=>Comment::count() / max(Post::count(),1),
            'top_users'=>User::withCount('posts')->orderByDesc('posts_count')->take(5)->get(),
            'top_tags'=>Tag::withCount('posts')->orderByDesc('posts_count')->take(5)->get()
        ]);
    }
}