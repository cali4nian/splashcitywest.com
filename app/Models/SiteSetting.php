<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function value(string $key, mixed $default = null): mixed
    {
        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $default;
        }

        return static::query()
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    /**
     * Fetch multiple settings in a single query.
     *
     * @param  array<string>  $keys
     * @param  array<string, mixed>  $defaults
     * @return array<string, mixed>
     */
    public static function values(array $keys, array $defaults = []): array
    {
        $instance = new static();

        if (! Schema::hasTable($instance->getTable())) {
            return $defaults;
        }

        $rows = static::query()
            ->whereIn('key', $keys)
            ->pluck('value', 'key');

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $rows->get($key) ?? ($defaults[$key] ?? null);
        }

        return $result;
    }
}
