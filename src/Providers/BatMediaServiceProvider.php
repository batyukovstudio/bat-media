<?php

namespace Batyukovstudio\BatMedia\Providers;

use Illuminate\Support\ServiceProvider;


class BatMediaServiceProvider extends ServiceProvider
{
    public array $serviceProviders = [
        // InternalServiceProviderExample::class,
    ];

    public array $aliases = [
        // 'Foo' => Bar::class,
    ];

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../../../database/migrations');


        $source = __DIR__ . '/../../config/bat-media.php';
        $this->publishes([
            $source => config_path('bat-media.php')
        ], 'bat-media-config');

    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/bat-media.php', 'bat-media'
        );
        parent::register();
    }

}
