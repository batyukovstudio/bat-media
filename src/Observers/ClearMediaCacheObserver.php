<?php

namespace Batyukovstudio\BatMedia\Observers;

use Batyukovstudio\BatMedia\MediaEntity\Contracts\HasEntityClassInterface;
use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\MediaConfigManager;
use Batyukovstudio\BatMedia\MediaEntity\Models\MediaEntity;
use Batyukovstudio\BatMedia\MediaEntity\Tasks\GetMediaConfigCacheKey;
use Illuminate\Support\Facades\Cache;

class ClearMediaCacheObserver
{
    public function created(HasEntityClassInterface $model): void
    {
        self::refreshMediaCache($model);
    }

    public function updated(HasEntityClassInterface $model): void
    {
        self::refreshMediaCache($model);
    }

    public function deleted(HasEntityClassInterface $model): void
    {
        if ($model instanceof MediaEntity) {
            $entityClass = $model->getEntityClass();
            $mediaConfigCacheKey = app(GetMediaConfigCacheKey::class)->run($entityClass);
            Cache::forget($mediaConfigCacheKey);
        } else {
            self::refreshMediaCache($model);
        }
    }

    private function refreshMediaCache(HasEntityClassInterface $model): void
    {
        $entityClass = $model->getEntityClass();
        $mediaConfigCacheKey = app(GetMediaConfigCacheKey::class)->run($entityClass);
        $configManager = new MediaConfigManager($entityClass);
        Cache::put($mediaConfigCacheKey, $configManager->getConfig());
    }
}
