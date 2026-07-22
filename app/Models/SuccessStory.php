<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SuccessStory extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'image_path',
    ];

    public static function publicStories(): array
    {
        $fallbackStories = [
            [
                'name' => 'Jalen M.',
                'title' => 'Earned a college roster spot',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'name' => 'Marcus T.',
                'title' => 'Team captain leadership growth',
                'description' => 'Led summer workouts and helped raise attendance standards for younger players.',
                'image_url' => asset('images/coachRoss1.png'),
            ],
            [
                'name' => 'Isaiah R.',
                'title' => 'All-tournament recognition',
                'description' => 'Turned defensive effort into impact plays and became a trusted closer in games.',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackStories;
        }

        $stories = static::query()
            ->orderBy('id')
            ->get(['name', 'title', 'description', 'image_path'])
            ->map(static function (SuccessStory $story): array {
                $fallbackImage = asset('images/coachRoss1.png');
                $imageUrl = $fallbackImage;

                if ($story->image_path && Storage::disk('public')->exists($story->image_path)) {
                    $imageUrl = Storage::url($story->image_path);
                }

                return [
                    'name' => $story->name,
                    'title' => $story->title,
                    'description' => $story->description,
                    'image_url' => $imageUrl,
                ];
            })
            ->toArray();

        return count($stories) > 0 ? $stories : $fallbackStories;
    }
}
