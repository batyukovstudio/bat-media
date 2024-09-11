<?php

namespace BatyukovStudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies;


use BatyukovStudio\BatMedia\MediaEntity\Contracts\HasBatImages;
use BatyukovStudio\BatMedia\MediaEntity\GetConfigStrategy\Interfaces\GetMediaConfigStrategy;

abstract class AbstractMediaConfigStrategy implements GetMediaConfigStrategy
{

    private HasBatImages $mediaEntityInstance;

    public function __construct(HasBatImages $mediaEntityInstance)
    {
        $this->setMediaEntityInstance($mediaEntityInstance);
    }

    public function getMediaEntityInstance(): HasBatImages
    {
        return $this->mediaEntityInstance;
    }

    public function setMediaEntityInstance(HasBatImages $mediaEntityInstance): void
    {
        $this->mediaEntityInstance = $mediaEntityInstance;
    }

    public function getMediaEntityClass(): string
    {
        return get_class($this->getMediaEntityInstance());
    }


}
