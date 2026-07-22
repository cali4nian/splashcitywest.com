<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SiteEvent extends Model
{
    protected $fillable = [
        'event_date',
        'title',
        'details',
        'image_path',
    ];

    public static function publicEvents(): array
    {
        $fallbackEvents = [
            [
                'date' => 'Jul 18, 2026',
                'title' => 'Splash City West Open Gym',
                'details' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'date' => 'Jul 25, 2026',
                'title' => 'Parent and Player Meeting',
                'details' => 'Team expectations, travel plans, and fundraiser goals at 5:30 PM',
                'image_url' => asset('images/coachRoss1.png'),
            ],
            [
                'date' => 'Aug 2, 2026',
                'title' => 'Roosevelt Skills Session',
                'details' => 'Ball handling, shooting reps, and defensive stations at 9:00 AM',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackEvents;
        }

        $events = static::query()
            ->orderBy('id')
            ->get(['event_date', 'title', 'details', 'image_path'])
            ->map(static function (SiteEvent $event): array {
                $fallbackImage = asset('images/coachRoss1.png');
                $imageUrl = $fallbackImage;

                if ($event->image_path && Storage::disk('public')->exists($event->image_path)) {
                    $imageUrl = Storage::url($event->image_path);
                }

                return [
                    'date' => $event->event_date,
                    'title' => $event->title,
                    'details' => $event->details,
                    'image_url' => $imageUrl,
                ];
            })
            ->toArray();

        return count($events) > 0 ? $events : $fallbackEvents;
    }
}
