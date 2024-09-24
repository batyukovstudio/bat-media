<?php

namespace Batyukovstudio\BatMedia\MediaEntity\GetConfigStrategy\Strategies;


use Batyukovstudio\BatMedia\MediaEntity\Models\MediaConversionSize;
use Batyukovstudio\BatMedia\MediaEntity\Models\MediaEntity;
use Batyukovstudio\BatMedia\MediaEntity\Models\MediaEntityConversion;

class GetConfigFromDatabaseStrategy extends AbstractMediaConfigStrategy
{

    public function run(): array
    {
        /** @var MediaEntity $mediaEntity */
        $mediaEntity = MediaEntity::where('entity_class', $this->getMediaEntityClass())
            ->with([
                'mediaEntityConversions' => fn($query) => $query->with('mediaConversionSizes')
            ])
            ->first();

        if ($mediaEntity === null) {
            throw new \Exception("Не заполнена конфигурация для сущности: " . $this->getMediaEntityClass());
        }

        $mediaConfig = [
            'width' => $mediaEntity->getWidth(),
            'height' => $mediaEntity->getHeight(),
            'quality' => $mediaEntity->getQuality(),
            'format' => $mediaEntity->getFormat(),
        ];

        $conversions = $mediaEntity->getMediaEntityConversions();

        /** @var MediaEntityConversion $conversion */
        foreach ($conversions as $conversion) {
            $sizes = $conversion->getMediaConversionSizes();

            $mediaConfig['collections'][$conversion->getName()] = [
                'width' => $conversion->getWidth(),
                'height' => $conversion->getHeight(),
                'quality' => $conversion->getQuality(),
                'format' => $conversion->getFormat(),
                'is_gallery' => $conversion->isGallery(),
            ];

            /** @var MediaConversionSize $size */
            foreach ($sizes as $size) {
                $mediaConfig['collections'][$conversion->getName()]['conversions'][$size->getNameValue()] = [
                    'width' => $size->getWidth(),
                    'height' => $size->getHeight(),
                    'quality' => $size->getQuality(),
                ];
            }
        }

        return $mediaConfig;
    }

}
