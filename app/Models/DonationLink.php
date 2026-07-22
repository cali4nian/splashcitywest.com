<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class DonationLink extends Model
{
    protected $fillable = [
        'name',
        'label',
        'url',
        'qr_code_image_path',
    ];

    public static function publicLinks(): array
    {
        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return [];
        }

        $accentMap = [
            'paypal' => 'from-[#2f7d32] to-[#0b3b8f]',
            'cash app' => 'from-[#00c389] to-[#0f7a5b]',
            'stripe' => 'from-[#f26a0a] to-[#b45309]',
        ];

        $links = static::query()
            ->orderBy('id')
            ->get(['name', 'label', 'url', 'qr_code_image_path'])
            ->map(static function (DonationLink $link) use ($accentMap): array {
                $accent = $accentMap[strtolower($link->name)] ?? 'from-[#1d4ed8] to-[#0f172a]';

                return [
                    'name' => $link->name,
                    'label' => $link->label,
                    'url' => $link->url,
                    'qr_code_image_url' => $link->qr_code_image_path ? Storage::url($link->qr_code_image_path) : null,
                    'accent' => $accent,
                ];
            })
            ->toArray();

        return $links;
    }
}
