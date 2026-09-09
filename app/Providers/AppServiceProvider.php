<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

        foreach ([
            storage_path('app/livewire-tmp'),
            storage_path('app/public/livewire-tmp'),
            storage_path('app/public/files/documents'),
        ] as $directory) {
            if (! is_dir($directory)) {
                @mkdir($directory, 0775, true);
            }
        }
    }
}
