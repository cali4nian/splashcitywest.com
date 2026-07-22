<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class StaffMember extends Model
{
    protected $fillable = [
        'name',
        'position',
        'email',
        'image_path',
    ];

    public static function publicMembers(): array
    {
        $fallbackMembers = [
            [
                'name' => 'Charles Ross',
                'position' => 'Head Coach',
                'email' => 'charles.ross@fresnounified.org',
                'image_url' => asset('images/coachRoss1.png'),
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackMembers;
        }

        $members = static::query()
            ->orderBy('id')
            ->get(['name', 'position', 'email', 'image_path'])
            ->map(static function (StaffMember $member): array {
                $fallbackImage = asset('images/coachRoss1.png');
                $imageUrl = $fallbackImage;

                if ($member->image_path && Storage::disk('public')->exists($member->image_path)) {
                    $imageUrl = Storage::url($member->image_path);
                }

                return [
                    'name' => $member->name,
                    'position' => $member->position,
                    'email' => $member->email,
                    'image_url' => $imageUrl,
                ];
            })
            ->toArray();

        return count($members) > 0 ? $members : $fallbackMembers;
    }
}
