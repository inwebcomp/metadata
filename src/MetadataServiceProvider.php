<?php

namespace InWeb\Metadata;

use Illuminate\Support\ServiceProvider;

class MetadataServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
