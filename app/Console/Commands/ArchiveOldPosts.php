<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ArchiveOldPosts extends Command
{
    protected $signature = 'posts:archive';

    protected $description = 'Archive posts older than 30 days';

    public function handle(): void
    {
        $dateLimit = Carbon::now()->subDays(30);

        $posts = Post::where('created_at', '<', $dateLimit)->get();

        $count = 0;

        foreach ($posts as $post) {
            $post->update([
                'is_archived' => true
            ]);

            $count++;
        }

        $this->info("Archived {$count} posts successfully.");
    }
}