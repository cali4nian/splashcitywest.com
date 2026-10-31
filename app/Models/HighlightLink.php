<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class HighlightLink extends Model
{
    protected $fillable = [
        'title',
        'url',
    ];

    public static function publicLinks(): array
    {
        $fallbackLinks = [
            [
                'title' => 'Splash City West Highlight Reel',
                'url' => 'https://www.youtube.com/watch?v=j_C7i5hVnbw',
            ],
            [
                'title' => 'Roosevelt Skills Session',
                'url' => 'https://www.youtube.com/watch?v=j_C7i5hVnbw',
            ],
            [
                'title' => 'Game Day Highlights',
                'url' => 'https://www.youtube.com/watch?v=j_C7i5hVnbw',
            ],
        ];

        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return array_map(static fn (array $link): array => static::normalizeLink($link), $fallbackLinks);
        }

        $links = static::query()
            ->orderBy('id')
            ->get(['title', 'url'])
            ->map(static fn (HighlightLink $link): array => static::normalizeLink([
                'title' => $link->title,
                'url' => $link->url,
            ]))
            ->toArray();

        if (count($links) > 0) {
            return $links;
        }

        return array_map(static fn (array $link): array => static::normalizeLink($link), $fallbackLinks);
    }

    private static function normalizeLink(array $link): array
    {
        $title = (string) ($link['title'] ?? 'Highlight Link');
        $url = (string) ($link['url'] ?? '');

        return [
            'title' => $title,
            'url' => $url,
            'embed_url' => static::toEmbedUrl($url),
        ];
    }

    private static function toEmbedUrl(string $url): ?string
    {
        $parts = parse_url($url);

        if (! is_array($parts)) {
            return null;
        }

        $host = strtolower((string) ($parts['host'] ?? ''));
        $path = (string) ($parts['path'] ?? '');

        if (str_contains($host, 'youtu.be')) {
            $videoId = trim($path, '/');

            return $videoId !== '' ? 'https://www.youtube.com/embed/' . $videoId : null;
        }

        if (str_contains($host, 'youtube.com')) {
            if (str_starts_with($path, '/embed/')) {
                $videoId = trim(substr($path, strlen('/embed/')), '/');

                return $videoId !== '' ? 'https://www.youtube.com/embed/' . $videoId : null;
            }

            if (str_starts_with($path, '/shorts/')) {
                $videoId = trim(substr($path, strlen('/shorts/')), '/');

                return $videoId !== '' ? 'https://www.youtube.com/embed/' . $videoId : null;
            }

            parse_str((string) ($parts['query'] ?? ''), $query);
            $videoId = trim((string) ($query['v'] ?? ''));

            return $videoId !== '' ? 'https://www.youtube.com/embed/' . $videoId : null;
        }

        return null;
    }
}
