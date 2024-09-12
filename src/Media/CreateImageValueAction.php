<?php

namespace BatyukovStudio\BatMedia\Media;

use Illuminate\Support\Facades\DB as ParentAction;
use BatyukovStudio\BatMedia\Values\Media\ImageValue;

class CreateImageValueAction extends ParentAction
{
    public function run(string $src, int $width, int $height): ImageValue
    {
        $value = new ImageValue();
        $value->setSrc($src);
        $value->setWidth($width);
        $value->setHeight($height);

        return $value;
    }
}
