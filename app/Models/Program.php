<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class Program extends Model
{
    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'image_path',
    ];

    public static function publicPrograms(): array
    {
        $fallbackPrograms = [
            [
                'name' => 'Splash City West',
                'subtitle' => 'AAU team',
                'description' => 'A dedicated home for the AAU program. Share tryouts, tournament schedules, training priorities, and the values that guide the team.',
                'image_url' => asset('images/coachRoss2.jpeg'),
            ],
            [
                'name' => 'Roosevelt High School',
                'subtitle' => 'High school program',
                'description' => 'A high-level Division II program built on high standards, accountability, and preparation for success in the classroom and in life.',
                'image_url' => asset('images/coachRoss1.png'),
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackPrograms;
        }

        $programs = static::query()
            ->orderBy('name')
            ->get(['name', 'subtitle', 'description', 'image_path'])
            ->map(static function (Program $program): array {
                $fallbackImage = asset('images/coachRoss1.png');

                $imageUrl = $fallbackImage;

                if ($program->image_path && Storage::disk('public')->exists($program->image_path)) {
                    $imageUrl = Storage::url($program->image_path);
                }

                return [
                    'name' => $program->name,
                    'subtitle' => $program->subtitle,
                    'description' => $program->description,
                    'image_url' => $imageUrl,
                ];
            })
            ->toArray();

        return count($programs) > 0 ? $programs : $fallbackPrograms;
    }
}
