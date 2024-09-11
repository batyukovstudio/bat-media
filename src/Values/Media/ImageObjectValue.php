<?php

namespace BatyukovStudio\BatMedia\Values\Media;

use BatyukovStudio\BatMedia\Parents\Values\Value;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ImageObjectValue extends Value
{
    public ?string $alt;

    public ImageOriginalValue $original_image;

    public Collection $conversions;

    public function getOriginalImage(): ImageOriginalValue
    {
        return $this->original_image;
    }

    public function setOriginalImage(ImageOriginalValue $original_image): self
    {
        $this->original_image = $original_image;
        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }

    public function getConversions(): Collection
    {
        return $this->conversions;
    }

    public function setConversions(Collection $conversions): self
    {
        $this->conversions = $conversions;
        return $this;
    }

    public function addConversion(ImageConversionsValue $conversion): self
    {
        $this->conversions->push($conversion);
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
