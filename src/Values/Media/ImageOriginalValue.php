<?php

namespace BatyukovStudio\BatMedia\Values\Media;

use BatyukovStudio\BatMedia\Parents\Values\Value;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class ImageOriginalValue extends Value
{
    public int $width;
    public int $height;
    public float $aspect_ratio;

    public string $src;
    public string $mime_type;

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

    public function getAspectRatio(): float
    {
        return $this->aspect_ratio;
    }

    public function setAspectRatio(float $aspect_ratio): self
    {
        $this->aspect_ratio = $aspect_ratio;
        return $this;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;
        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;
        return $this;
    }



    public function toArray(): array
    {
        $result = [];
        $vars = get_object_vars($this);

        foreach ($vars as $name => $value) {
            if ($value instanceof Arrayable) {
                if (count($value->toArray()) > 0) {
                    $value = $value->toArray();
                } else {
                    $value = null;
                }
            } elseif (is_object($value) && property_exists($value, 'value')) {
                $value = $value->value;
            } elseif (is_array($value)) {
                foreach ($value as $valueItemKey => $valueItem) {
                    if ($valueItem instanceof Arrayable) {
                        $value[$valueItemKey] = $valueItem->toArray();
                    }
                }
            }

            $result[Str::snake((string)$name)] = $value;
        }

        return $result;
    }
}
