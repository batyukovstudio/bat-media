<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Traits;

use BatyukovStudio\BatMedia\Media\CreateImageConversionsValueAction;
use BatyukovStudio\BatMedia\Media\CreateImageObjectValueAction;
use BatyukovStudio\BatMedia\Media\CreateImageValueAction;
use BatyukovStudio\BatMedia\MediaEntity\Enums\MediaDriverEnum;
use BatyukovStudio\BatMedia\MediaEntity\Enums\MediaFormat;
use BatyukovStudio\BatMedia\MediaEntity\GetConfigStrategy\MediaConfigManager;
use BatyukovStudio\BatMedia\MediaEntity\Handlers\MediaConfigHandler;
use BatyukovStudio\BatMedia\Values\Media\ImageObjectValue;
use BatyukovStudio\BatMedia\Values\Media\ImageOriginalValue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait InteractsWithBatImages
{
    use InteractsWithMedia;

    private const MIME_TYPE_PREFIX = 'image/';
    private const CONFIG_COLLECTION_KEY = 'collections';

    private const CONFIG_DRIVER_DEFAULT = MediaDriverEnum::CONFIG_FILE;

    public function getMediaConfigProvider(): MediaDriverEnum
    {
        return config('bat-media.config_provider', self::CONFIG_DRIVER_DEFAULT);
    }

    /**
     * @throws \Exception
     */
    public function getMediaConfigHandler(): MediaConfigHandler
    {
        $configManager = new MediaConfigManager(self::class);
        $config = $configManager->getConfig();
        return $config;
    }

    public function getFullConversionName(string $collectionName, string $conversionName): string
    {
        return $collectionName . '_' . $conversionName;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addImage(string|UploadedFile $file, string $collectionName): Media
    {
        $manager = new ImageManager(new Driver());

        $imageInstance = $manager->read($file);

        return $this->addMedia($file)
            ->withCustomProperties([
                'original_width' => $imageInstance->width(),
                'original_height' => $imageInstance->height(),
            ])
            ->toMediaCollection($collectionName);
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addImageFromUrl(string $url, string $collectionName, array|string ...$allowedMimeTypes): Media
    {
        $manager = new ImageManager(new Driver());
        $response = Http::get($url);
        $imageInstance = $manager->read($response->body());

        return $this->addMediaFromUrl($url, $allowedMimeTypes)
            ->withCustomProperties([
                'original_width' => $imageInstance->width(),
                'original_height' => $imageInstance->height(),
            ])
            ->toMediaCollection($collectionName);
    }


    /**
     * @param string $collectionName
     * @param string|null $alt
     * @return Collection|ImageObjectValue|null
     *
     * Коллекция - массив конверсий (пример, preview_image)
     * Конверсия - форматированная нарезанная картинка (пример, small, large)
     *
     */
    public function getImageObject(string $collectionName, ?string $alt = null): array|ImageObjectValue|null
    {
        try {
            $configHandler = self::getMediaConfigHandler();
            $configHandler->changeCollectionConfig($collectionName);
            $conversions = $configHandler->getConversions();
        } catch (\Throwable $exception) {
            $conversions = [];

            Log::critical(
                'Ошибка при получении конфига BatMedia. ' . PHP_EOL .
                'Model: ' . self::class . '. ' . PHP_EOL .
                'Collection Name: ' . $collectionName . '. ' . PHP_EOL .
                'Message: ' . $exception->getMessage(),
                $exception->getTrace(),
            );
        }

        $resultImage = null;
        $mediaConversions = $this->getMedia($collectionName);

        if (count($mediaConversions) === 0) {
            return null;
        }

        /** @var MediaCollection $media
         * @var Media $media
         * Коллекция от spatie, перебираем ее и сравниваем каждую конверсию с конверсией из конфига
         * */
        foreach ($mediaConversions as $media) {

            $imageValues = [];
            $mimeType = $media->mime_type;

            $originalWidth = $media->getCustomProperty('original_width');
            $originalHeight = $media->getCustomProperty('original_height');

            /**
             * @var array $conversionData
             * @var array $conversions
             * Информация о конверсиях из конфига (Spatie не хранит все, что мы сделали с конверсией, а конфиг хранит, раз по нему делали)
             */
            foreach ($conversions as $conversionName => $conversionData) {
                try {
                    $configHandler->changeConversionConfig($conversionName);

                    $width = $configHandler->getWidth();
                    $height = $configHandler->getHeight();
                    $format = $configHandler->getFormat()?->value ?? str_replace(self::MIME_TYPE_PREFIX, '', $mimeType);
                    $fullConversionName = $configHandler->getFullConversionName();
                    $src = $media->getUrl($fullConversionName);

                    $imageValues[$format][$conversionName] = app(CreateImageValueAction::class)->run($src, $width, $height);
                } catch (\Exception $exception) {
                    Log::critical(
                        'Ошибка при получении конфига конверсии BatMedia. ' . PHP_EOL .
                        'Model: ' . self::class . '. ' . PHP_EOL .
                        'Collection: ' . $collectionName . '. ' . PHP_EOL .
                        'Conversion: ' . $conversionName . '. ' . PHP_EOL .
                        'Message: ' . $exception->getMessage(),
                        $exception->getTrace(),
                    );
                }
            }

            /**
             * @var array $imageValues
             * @var array $imageValuesArr массив с конверсиями определенного формата - $finalFormat
             * @var string $finalFormat - формат (пример, webp, jpg)
             * Создаем для форматов свой объект - ImageConversionsValue, внутри mime_type и image_sizes(конверсии)
             */
            foreach ($imageValues as $finalFormat => $imageValuesArr) {
                $imageValuesCollection = collect($imageValuesArr);
                $imageConversionValues[$finalFormat] = app(CreateImageConversionsValueAction::class)
                    ->run(self::MIME_TYPE_PREFIX . $finalFormat, $imageValuesCollection);
            }

            $originalImage = (new ImageOriginalValue())
                ->setSrc($media->getUrl())
                ->setWidth($originalWidth)
                ->setHeight($originalHeight)
                ->setAspectRatio(round($originalHeight / $originalWidth, 2))
                ->setMimeType($mimeType);


            $imageConversionValuesCollection = collect($imageConversionValues ?? []);

            $imageObject = app(CreateImageObjectValueAction::class)
                ->run($alt, $originalImage, $imageConversionValuesCollection) ?? null;

            if (true === $configHandler->isGallery()) {
                $resultImage[] = $imageObject;
            } else {
                // Выходим из функции после первой проходки и возвращаем первый объект
                $resultImage = $imageObject;
                continue;
            }
        }

        return $resultImage;
    }

    /**
     * @return void
     * Функция из пакета spatieMediaLibrary
     * Внутри нее динамически заполняется информация о конверсиях из конфига или базы на выбор
     * @throws \Exception
     */
    public function registerMediaCollections(): void
    {
        $configHandler = self::getMediaConfigHandler();
        $collections = $configHandler->getCollections();

        foreach ($collections as $collectionName => $collectionConfig) {
            $configHandler = clone $configHandler;
            $configHandler->changeCollectionConfig($collectionName);

            $this
                ->addMediaCollection($collectionName)
                ->registerMediaConversions(function (Media $media) use ($configHandler, $collectionName) {
                    $conversions = $configHandler->getConversions();

                    foreach ($conversions as $conversionName => $conversionConfig) {

                        $configHandler->changeConversionConfig($conversionName);

                        $fullConversionName = $configHandler->getFullConversionName();
                        $conversionInstance = $this->addMediaConversion($fullConversionName);

                        $format = $configHandler->getFormat()?->value;
                        $width = $configHandler->getWidth();
                        $height = $configHandler->getHeight();
                        $isQueued = $configHandler->isQueued();
                        $quality = $configHandler->getQuality();

                        $conversionInstance->quality($quality);
                        $conversionInstance->optimize();

                        if ($isQueued === false) {
                            $conversionInstance->nonQueued();
                        }

                        if ($width !== null) {
                            $conversionInstance->width($width);
                        }

                        if ($height !== null) {
                            $conversionInstance->height($height);
                        }

                        if ($format === null) {
                            $mimeType = str_replace(self::MIME_TYPE_PREFIX, '', $media->mime_type);
                            if ($mimeType === 'jpeg') {
                                $media->mime_type = 'image/jpg';
                                $media->save();

                                $mimeType = MediaFormat::JPG->value;
                                $conversionInstance->format($mimeType);
                            }
                        } else {
                            $conversionInstance->format($format);
                        }
                    }
                });
        }
    }
}
