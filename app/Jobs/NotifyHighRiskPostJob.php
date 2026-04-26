<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class NotifyHighRiskPostJob implements ShouldQueue
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        Log::warning('High risk post detected', [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'risk_score' => $this->post->risk_score
        ]);
    }
}