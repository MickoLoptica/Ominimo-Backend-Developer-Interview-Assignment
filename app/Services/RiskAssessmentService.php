<?php

namespace App\Services;

class RiskAssessmentService
{
    public function calculate($content)
    {
        $score = 20;

        $keywords = ['accident', 'fire', 'theft', 'damage'];

        foreach ($keywords as $word) {
            if (stripos($content, $word) !== false) {
                $score += 50;
                break;
            }
        }

        if (strlen($content) < 50) {
            $score += 10;
        }

        $level = 'low';

        if ($score >= 70) {
            $level = 'high';
        } elseif ($score >= 30) {
            $level = 'medium';
        }

        return [
            'score' => $score,
            'level' => $level
        ];
    }
}