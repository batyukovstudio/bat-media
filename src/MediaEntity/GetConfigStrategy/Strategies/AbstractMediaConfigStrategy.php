<?php

namespace Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies;


use Batyukovstudio\BatMedia\MediaEntity\Contracts\HasBatImages;
use Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Interfaces\GetMediaConfigStrategy;

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
