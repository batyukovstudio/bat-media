<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * The Main Service Provider of this container.
 * It will be automatically registered by the framework.
 * @method publishesMigrations(array $array)
 */
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

        $this->publishesMigrations([
            __DIR__.'/../Data/Migrations' => database_path('migrations'),
        ]);


        $source = __DIR__ . '/../../../config/bat-media.php';
        $this->publishes([
            $source => config_path('bat-media.php')
        ], 'bat-media-config');

    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../../config/bat-media.php', 'bat-media'
        );
        parent::register();
    }

}
