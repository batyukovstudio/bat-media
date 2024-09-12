<?php

namespace BatyukovStudio\BatMedia\Media;

use Illuminate\Support\Facades\DB as ParentAction;
use BatyukovStudio\BatMedia\Values\Media\ImageObjectValue;
use BatyukovStudio\BatMedia\Values\Media\ImageOriginalValue;
use Illuminate\Support\Collection;

class CreateImageObjectValueAction extends ParentAction
{
    public function run(?string $alt, ImageOriginalValue $originalImage, Collection $conversions): ImageObjectValue
    {
        $value = new ImageObjectValue();
        $value->setAlt($alt);
        $value->setOriginalImage($originalImage);
        $value->setConversions($conversions);

        return $value;
    }
}
