<?php

namespace Batyukovstudio\BatMedia\Media;

use Illuminate\Support\Facades\DB as ParentAction;
use Batyukovstudio\BatMedia\Values\Media\ImageConversionsValue;
use Illuminate\Support\Collection;

class CreateImageConversionsValueAction extends ParentAction
{
    public function run(string $mimeType, Collection $imageSizes): ImageConversionsValue
    {
        $value = new ImageConversionsValue();
        $value->setMimeType($mimeType);
        $value->setImageSizes($imageSizes);

        return $value;
    }
}
