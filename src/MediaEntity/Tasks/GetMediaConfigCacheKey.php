<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Tasks;

class GetMediaConfigCacheKey
{
    public function run(string $class): string
    {
        return $class . '-batImageCacheKey';
    }
}
