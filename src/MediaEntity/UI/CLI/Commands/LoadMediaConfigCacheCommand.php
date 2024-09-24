<?php

namespace Batyukovstudio\BatMedia\MediaEntity\UI\CLI\Commands;

use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\MediaConfigManager;
use Batyukovstudio\BatMedia\MediaEntity\Tasks\GetMediaConfigCacheKey;
use Batyukovstudio\BatMedia\MediaEntity\Tasks\ListMediaEntityClasses;
use Batyukovstudio\BatMedia\Parents\Commands\ConsoleCommand;
use Batyukovstudio\BatMedia\Services\ProgressBar\ProgressBar;
use Illuminate\Support\Facades\Cache;

class LoadMediaConfigCacheCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media-cache:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Загружает кэш конфигов всех медиа-сущностей';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $existMediaEntityClasses = app(ListMediaEntityClasses::class)->run();
        $total = count($existMediaEntityClasses);
        $progressBar = new ProgressBar($total);
        $progressBar->start();

        foreach ($existMediaEntityClasses as $entityClass) {
            $mediaConfigCacheKey = app(GetMediaConfigCacheKey::class)->run($entityClass);
            $configManager = new MediaConfigManager($entityClass);
            Cache::put($mediaConfigCacheKey, $configManager->getConfig());
            $progressBar->advance();
        }
        $progressBar->finish();
    }
}
