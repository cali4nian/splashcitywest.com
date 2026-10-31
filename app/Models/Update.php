<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class Update extends Model
{
    public const CATEGORY_PROGRAM = 'program';
    public const CATEGORY_EVENT = 'event';
    public const CATEGORY_SUCCESS_STORY = 'success_story';

    protected $fillable = [
        'category',
        'title',
        'subtitle',
        'description',
        'image_path',
        'sort_order',
    ];

    public static function categoryOptions(): array
    {
        return [
            self::CATEGORY_PROGRAM => 'Program',
            self::CATEGORY_EVENT => 'Current Event',
            self::CATEGORY_SUCCESS_STORY => 'Success Story',
        ];
    }

    public static function publicUpdates(): array
    {
        $fallbackUpdates = [
            [
                'category' => self::CATEGORY_PROGRAM,
                'category_label' => 'Program',
                'title' => 'Splash City West',
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'category' => self::CATEGORY_PROGRAM,
                'category_label' => 'Program',
                'title' => 'Roosevelt High School',
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
                'image_url' => asset('images/coachRoss1.png'),
            ],
            [
                'category' => self::CATEGORY_EVENT,
                'category_label' => 'Current Event',
                'title' => 'Splash City West Open Gym',
                'subtitle' => 'Jul 18, 2026',
                'description' => 'Roosevelt Main Gym, 6:00 PM to 8:00 PM',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'category' => self::CATEGORY_SUCCESS_STORY,
                'category_label' => 'Success Story',
                'title' => 'Earned a college roster spot',
                'subtitle' => 'Jalen M.',
                'description' => 'Improved GPA and consistency through daily accountability and skill sessions.',
                'image_url' => asset('images/coachRoss1.png'),
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackUpdates;
        }

        $updates = static::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['category', 'title', 'subtitle', 'description', 'image_path'])
            ->map(static function (Update $update): array {
                $fallbackImage = asset('images/coachRoss1.png');
                $imageUrl = $fallbackImage;

                if ($update->image_path && Storage::disk('public')->exists($update->image_path)) {
                    $imageUrl = Storage::url($update->image_path);
                }

                $categoryLabel = static::categoryOptions()[$update->category] ?? 'Update';

                return [
                    'category' => $update->category,
                    'category_label' => $categoryLabel,
                    'title' => $update->title,
                    'subtitle' => $update->subtitle,
                    'description' => $update->description,
                    'image_url' => $imageUrl,
                ];
            })
            ->toArray();

        return count($updates) > 0 ? $updates : $fallbackUpdates;
    }
}
