<?php

namespace Batyukovstudio\BatMedia\Parents\Values;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

abstract class Value
{
    public static function run(): static
    {
        $static = new static();
        $static->mount();

        return $static;
    }

    public function toArray(): array
    {
        $result = [];
        $vars = get_object_vars($this);

        foreach ($vars as $name => $value) {
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            } elseif (is_object($value) && property_exists($value, 'value')) {
                $value = $value->value;
            } elseif (is_array($value)) {
                foreach ($value as $valueItemKey => $valueItem) {
                    if ($valueItem instanceof Arrayable) {
                        $value[$valueItemKey] = $valueItem->toArray();
                    }
                }
            }

            $result[(Str::snake((string) $name))] = $value;
        }

        return $result;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    protected function mount(): void
    {

    }
}
