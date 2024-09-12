<?php

namespace BatyukovStudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies;

class GetConfigFromConfigFileStrategy extends AbstractMediaConfigStrategy
{

    public function run(): array
    {
        $this->validate();
        $mediaEntityInstance = $this->getMediaEntityInstance();
        $mediaConfigName = $mediaEntityInstance->getMediaConfigName();
        $mediaConfig = config($mediaConfigName);

        return $mediaConfig;
    }

    /**
     * @throws \Exception
     */
    public function validate(): bool
    {
        $mediaEntityInstance = $this->getMediaEntityInstance();
        if (!method_exists($mediaEntityInstance, 'getMediaConfigName')) {
            throw new \Exception("Required method getMediaConfigName is missed for " . $this->getMediaEntityClass());
        }

        return true;
    }


}
