<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Contracts;

use BatyukovStudio\BatMedia\MediaEntity\Enums\MediaDriverEnum;
use BatyukovStudio\BatMedia\MediaEntity\Handlers\MediaConfigHandler;
use Spatie\MediaLibrary\HasMedia;

interface HasBatImages extends HasMedia
{
    public function getMediaConfigProvider(): MediaDriverEnum;

    public function getMediaConfigHandler(): MediaConfigHandler;

    public function getFullConversionName(string $collectionName, string $conversionName): string;

    public function getImageObject(string $collectionName, ?string $alt = null); //: Collection|ImageObjectValue|null;
}
