<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\RiskAssessmentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculatePostRiskJob implements ShouldQueue
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(): void
    {
        $service = new RiskAssessmentService();

        $result = $service->calculate($this->post->content);

        $this->post->update([
            'risk_score' => $result['score'],
            'risk_level' => $result['level']
        ]);

        if ($result['level'] === 'high') {
            NotifyHighRiskPostJob::dispatch($this->post);
        }
    }
}