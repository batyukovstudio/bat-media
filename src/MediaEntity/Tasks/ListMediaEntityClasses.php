<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Tasks;

use Batyukovstudio\BatMedia\MediaEntity\Contracts\HasBatImages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ListMediaEntityClasses
{
    public function run(): array
    {
        $modelsDirectory = app_path('Containers');

        $files = File::allFiles($modelsDirectory);

        $modelNames = [];

        foreach ($files as $file) {
            $filePath = $file->getRealPath();

            if (Str::endsWith($filePath, '.php')) {
                $content = file_get_contents($filePath);
                preg_match('/[\s|\S]*?[\w|\W]*?InteractsWithBatImages[\s|\S]*?[\w|\W]*?class\s+(\w+)(\s+extends\s+\w+)?(\s+implements\s+\w+)?/', $content, $matches);
                $className = $matches[1] ?? null;

                if (!empty($className)) {
                    $modelPath = 'App' . Str::replace('/', '\\', Str::beforeLast(Str::afterLast($filePath, 'app'), '.php'));

                    $model = new $modelPath;
                    if ($model instanceof HasBatImages) {
                        $modelNames[] = $modelPath;
                    }
                }
            }
        }

        return $modelNames;
    }
}
