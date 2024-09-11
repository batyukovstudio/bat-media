<?php

namespace BatyukovStudio\BatMedia\Values\Media;

use BatyukovStudio\BatMedia\Parents\Values\Value;

class ImageValue extends Value
{
    public string $src;

    public int $width;

    public int $height;

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(?string $src): void
    {
        $this->src = $src;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }
}
