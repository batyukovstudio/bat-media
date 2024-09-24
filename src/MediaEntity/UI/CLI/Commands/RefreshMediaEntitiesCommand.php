<?php

namespace Batyukovstudio\BatMedia\MediaEntity\UI\CLI\Commands;

use Batyukovstudio\BatMedia\MediaEntity\Models\MediaEntity;
use Batyukovstudio\BatMedia\MediaEntity\Tasks\ListMediaEntityClasses;
use Batyukovstudio\BatMedia\Parents\Commands\ConsoleCommand;
use Batyukovstudio\BatMedia\Services\ProgressBar\ProgressBar;
use Illuminate\Support\Str;

class RefreshMediaEntitiesCommand extends ConsoleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media-entities:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет список медиа-сущностей, если появились новые.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $total = MediaEntity::query()->count();

        $existMediaEntityClasses = app(ListMediaEntityClasses::class)->run();
        $mediaEntitiesClasses = MediaEntity::all()->pluck('entity_class');
        $progressBar = new ProgressBar($total);
        $progressBar->start();

        foreach ($existMediaEntityClasses as $existMediaEntityClass) {
            if ($mediaEntitiesClasses->containsStrict($existMediaEntityClass) === false) {
                MediaEntity::create([
                    'name' => Str::afterLast($existMediaEntityClass, '\\'),
                    'description' => null,
                    'entity_class' => $existMediaEntityClass,
                    'width' => null,
                    'height' => null,
                    'quality' => null,
                    'format' => null,
                    'queued' => null,
                ]);
            }
            $progressBar->advance();
        }
        $progressBar->finish();
    }
}
