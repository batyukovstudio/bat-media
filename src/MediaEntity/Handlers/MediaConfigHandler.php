<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Handlers;

use Batyukovstudio\BatMedia\MediaEntity\Enums\MediaFormat;

class MediaConfigHandler
{
    private array $config;
    private ?array $collectionConfig = null;
    private ?string $collectionName = null;
    private ?array $conversionConfig = null;
    private ?string $conversionName = null;

    /**
     * @throws \Exception
     */
    public function __construct(array $config, ?string $collectionName = null, ?string $conversionName = null)
    {
        $this->config = $config;
        $this->validateConfig();

        if ($collectionName !== null) {
            $this->changeCollectionConfig($collectionName);

            if ($conversionName !== null) {
                $this->changeConversionConfig($conversionName);
            }
        }
    }


///////////////////////////////////////////////////////////////////
//////////////////Получение основных свойств///////////////////////
///////////////////////////////////////////////////////////////////

    public function getFullConversionName(): string
    {
        return $this->collectionName . '_' . $this->conversionName;
    }

    public function getWidth(): ?int
    {
        return $this->getProperty('width', $this->conversionName);
    }

    public function getHeight(): ?int
    {
        return $this->getProperty('height', $this->conversionName);
    }

    public function getQuality(): int
    {
        return $this->getProperty('quality', $this->conversionName);
    }

    public function isQueued(): bool
    {
        return $this->getSecondaryProperty('is_queued');
    }

    public function getFormat(): ?MediaFormat
    {
        return $this->getSecondaryProperty('format');
    }

    public function isGallery(): bool
    {
        return $this->getSecondaryProperty('is_gallery') ?? false;
    }



///////////////////////////////////////////////////////////////////
//////////////////Вспомогательные функции /////////////////////////
///////////////////////////////////////////////////////////////////


    public function getCollections(): array
    {
        return $this->config['collections'];
    }

    public function getConversions(): array
    {
        $this->validateCollectionConfig();
        return $this->collectionConfig['conversions'];
    }

    public function getProperty(string $propertyName, string $conversionName = null): mixed
    {
        return $this->getPrimaryProperty($conversionName, $propertyName) ?? $this->getSecondaryProperty($propertyName);
    }

    public function getPrimaryProperty(string $conversionName, string $propertyName): mixed
    {
        return $this->conversionConfig[$propertyName] ?? null;
    }

    public function getSecondaryProperty(string $propertyName): mixed
    {
        return $this->collectionConfig[$propertyName] ??
            $this->config[$propertyName] ??
            config('bat-media.' . $propertyName);
    }

    /**
     * @throws \Exception
     */
    public function changeCollectionConfig(string $collectionName): void
    {
        $this->collectionName = $collectionName;
        $this->validateCollectionConfig();
        $this->collectionConfig = $this->config['collections'][$collectionName];
    }

    /**
     * @throws \Exception
     */
    public function changeConversionConfig(string $conversionName): void
    {
        $this->conversionName = $conversionName;
        $this->validateConversionConfig();
        $this->conversionConfig = $this->collectionConfig['conversions'][$conversionName];
    }


    /**
     * @throws \Exception
     */
    public function validateConfig(): bool
    {
        if (!isset($this->config['collections'])) {
            throw new \Exception('Invalid media configuration');
        }

        return true;
    }

    /**
     * Коллекция точно существует и у нее есть конверсии
     * @throws \Exception
     */
    public function validateCollectionConfig(): bool
    {
        if (!isset($this->config['collections'][$this->collectionName]['conversions'])) {
            throw new \Exception('Invalid media collection configuration: ' .
                'collections.' . $this->collectionName
            );
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    public function validateConversionConfig(): bool
    {
        if (!isset($this->config['collections'][$this->collectionName]['conversions'][$this->conversionName])) {
            throw new \Exception('Invalid media conversion configuration: ' .
                'collections.' . $this->collectionName . '.conversions.' . $this->conversionName
            );
        }

        return true;
    }

}