<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->with('tags','user')->withCount('comments');

        if($request->date_from){
            $query->whereDate('created_at','>=',$request->date_from);
        }

        if($request->date_to){
            $query->whereDate('created_at','<=',$request->date_to);
        }

        if($request->risk_level){
            $query->where('risk_level',$request->risk_level);
        }

        if($request->comments_min){
            $query->has('comments','>=',$request->comments_min);
        }

        if($request->user_role){
            $query->whereHas('user',function($q) use ($request){
                $q->where('role',$request->user_role);
            });
        }

        return response()->json(
            $query->paginate(request('per_page',10))
        );
    }
}