<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SocialLink extends Model
{
    protected $fillable = [
        'platform',
        'handle',
        'url',
    ];

    public static function publicLinks(): array
    {
        $fallbackLinks = [
            [
                'label' => 'Instagram',
                'value' => '@splash_city_west',
                'href' => 'https://www.instagram.com/splash_city_west/',
            ],
            [
                'label' => 'Instagram',
                'value' => '@charles559209f',
                'href' => 'https://www.instagram.com/charles559209f/',
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $fallbackLinks;
        }

        $links = static::query()
            ->orderBy('id')
            ->get(['platform', 'handle', 'url'])
            ->map(static function (SocialLink $link): array {
                return [
                    'label' => $link->platform,
                    'value' => $link->handle ?: parse_url($link->url, PHP_URL_HOST) ?: $link->url,
                    'href' => $link->url,
                ];
            })
            ->toArray();

        return count($links) > 0 ? $links : $fallbackLinks;
    }
}
