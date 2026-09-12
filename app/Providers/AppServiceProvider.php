<?php

namespace App\Providers;

use RuntimeException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->enforceLocalSafetyGuard();
    }

    /**
     * Prevent local development from using non-local service endpoints.
     */
    private function enforceLocalSafetyGuard(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        if (! filter_var((string) env('LOCAL_SAFETY_CHECK', true), FILTER_VALIDATE_BOOL)) {
            return;
        }

        $checks = [
            'APP_URL' => (string) config('app.url', ''),
            'DB_HOST' => (string) data_get(config('database.connections'), config('database.default').'.host', ''),
            'REDIS_HOST' => (string) data_get(config('database.redis.default'), 'host', ''),
            'MAIL_HOST' => (string) data_get(config('mail.mailers.smtp'), 'host', ''),
        ];

        foreach ($checks as $name => $value) {
            if ($name === 'MAIL_HOST' && $this->isAllowedMailTestingHost($value)) {
                continue;
            }

            if ($this->isLikelyLocalEndpoint($value)) {
                continue;
            }

            throw new RuntimeException(
                sprintf(
                    'Local safety check blocked startup: %s is set to "%s". Use local endpoints or set LOCAL_SAFETY_CHECK=false to bypass intentionally.',
                    $name,
                    $value
                )
            );
        }
    }

    /**
     * Accept local URLs/hosts and common local container hostnames.
     */
    private function isLikelyLocalEndpoint(string $value): bool
    {
        $value = trim($value);

        if ($value === '') {
            return true;
        }

        $host = parse_url($value, PHP_URL_HOST);
        $host = is_string($host) && $host !== '' ? $host : $value;
        $host = strtolower($host);

        $localHosts = [
            'localhost',
            '127.0.0.1',
            '::1',
            'mysql',
            'mariadb',
            'db',
            'postgres',
            'redis',
            'mailpit',
            'mailhog',
            'sail-mysql',
        ];

        if (in_array($host, $localHosts, true)) {
            return true;
        }

        if (str_ends_with($host, '.local') || str_ends_with($host, '.localhost') || str_ends_with($host, '.test')) {
            return true;
        }

        if (preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[0-1])\.)/', $host) === 1) {
            return true;
        }

        return false;
    }

    /**
     * Allow trusted email testing providers in local development.
     */
    private function isAllowedMailTestingHost(string $value): bool
    {
        $value = trim($value);

        if ($value === '') {
            return false;
        }

        $host = parse_url($value, PHP_URL_HOST);
        $host = is_string($host) && $host !== '' ? $host : $value;
        $host = strtolower($host);

        return $host === 'sandbox.smtp.mailtrap.io' || str_ends_with($host, '.mailtrap.io');
    }
}
