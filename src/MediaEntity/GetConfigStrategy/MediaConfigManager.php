<?php

namespace Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy;

use Batyukovstudio\BatMedia\MediaEntity\Contracts\HasBatImages;
use Batyukovstudio\BatMedia\MediaEntity\Enums\MediaDriverEnum;
use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Interfaces\GetMediaConfigStrategy;
use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies\GetConfigFromConfigFileStrategy;
use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies\GetConfigFromDatabaseStrategy;
use Batyukovstudio\BatMedia\MediaEntity\Handlers\MediaConfigHandler;

class MediaConfigManager
{
    private string $entityClass;
    private HasBatImages $entityInstance;
    private GetMediaConfigStrategy $getMediaConfigStrategy;

    public function __construct(string $entityClass)
    {
        $this->entityClass = $entityClass;
        $this->entityInstance = self::validateMediaInstance($this->entityClass);
        $this->getMediaConfigStrategy = self::defineStrategyByEntityClass($this->entityInstance);
    }

    /**
     * @throws \Exception
     */
    public function getConfig(): MediaConfigHandler
    {
        $config = $this->getMediaConfigStrategy->run();
        $configHandler = new MediaConfigHandler($config);
        return $configHandler;
    }

    private static function defineStrategyByEntityClass(HasBatImages $mediaEntity): GetMediaConfigStrategy
    {
        $configDriver = $mediaEntity->getMediaConfigProvider();
        switch ($configDriver) {
            case MediaDriverEnum::DATABASE:
                $strategy = new GetConfigFromDatabaseStrategy($mediaEntity);
                break;
            case MediaDriverEnum::CONFIG_FILE:
                $strategy = new GetConfigFromConfigFileStrategy($mediaEntity);
                break;
        }

        return $strategy;
    }

    private static function validateMediaInstance(string $entityClass): HasBatImages
    {
        $entityInstance = new $entityClass();
        if (false === ($entityInstance instanceof HasBatImages)) {
            throw new \InvalidArgumentException('Entity class("' . $entityClass . '") must implement HasMediaImages');
        }

        return $entityInstance;
    }


}