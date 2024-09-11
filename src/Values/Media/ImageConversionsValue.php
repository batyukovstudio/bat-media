<?php

namespace BatyukovStudio\BatMedia\Values\Media;

use BatyukovStudio\BatMedia\Parents\Values\Value;
use Illuminate\Support\Collection;

class ImageConversionsValue extends Value
{
    public string $mime_type;

    public Collection $image_sizes;

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mimeType): void
    {
        $this->mime_type = $mimeType;
    }

    public function getImageSizes(): Collection
    {
        return $this->image_sizes;
    }

    public function setImageSizes(Collection $imageSizes): void
    {
        $this->image_sizes = $imageSizes;
    }
}
