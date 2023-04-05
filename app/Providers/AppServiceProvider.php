<?php

namespace App\Providers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\Input;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO: bugfix for DigitalOcean Mysql Server issue
        Event::listen(MigrationsStarted::class, function () {
            if (env('ALLOW_DISABLED_PK')) {
                DB::statement('SET SESSION sql_require_primary_key=0');
            }
        });

        // TODO: bugfix for DigitalOcean Mysql Server issue
        Event::listen(MigrationsEnded::class, function () {
            if (env('ALLOW_DISABLED_PK')) {
                DB::statement('SET SESSION sql_require_primary_key=1');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // TODO: bugfix for issue that paginator creating http links 
        // over https on DigitalOcean server
        if (config('app.env') === 'production') {
            // URL::forceScheme('https'); // this doesn't work!
            $this->app['request']->server->set('HTTPS', true);
        }

        // add query string to paginator globally
        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->withQueryString();
        });
    }
}
