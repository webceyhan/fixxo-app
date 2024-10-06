<?php

namespace App\Providers;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class DigitalOceanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // skip if not on production
        if (!app()->isProduction()) {
            return;
        }

        // Bugfix: DigitalOcean MySQL Server requires primary key for all tables

        // bypass primary key requirement before migrations
        Event::listen(MigrationsStarted::class, function () {
            $this->setSqlRequirePrimaryKey(false);
        });

        // restore primary key requirement after migrations
        Event::listen(MigrationsEnded::class, function () {
            $this->setSqlRequirePrimaryKey(true);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // skip if not on production
        if (!app()->isProduction()) {
            return;
        }

        // Bugfix: paginator links are not https

        // URL::forceScheme('https'); // this doesn't work!
        $this->app['request']->server->set('HTTPS', true);
    }

    private function setSqlRequirePrimaryKey(bool $enable): void
    {
        // skip if not allowed
        if (!env('ALLOW_DISABLED_PK')) {
            return;
        }

        $value = $enable ? 1 : 0;
        DB::statement("SET SESSION sql_require_primary_key={$value}");
    }
}
