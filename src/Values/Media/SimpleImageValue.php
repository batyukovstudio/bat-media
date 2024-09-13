<?php

namespace Batyukovstudio\BatMedia\Values\Media;


use Batyukovstudio\BatMedia\Parents\Values\Value as ParentValue;

class SimpleImageValue extends ParentValue
{
    public string $alt;
    public int $width;
    public int $height;
    public string $path;
    public int $size;

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function toArray(): array
    {
        return [
          'alt' => $this->getAlt(),
          'width' => $this->getWidth(),
          'height' => $this->getHeight(),
          'path' => $this->getPath(),
          'size' => $this->getSize(),
        ];
    }
}
