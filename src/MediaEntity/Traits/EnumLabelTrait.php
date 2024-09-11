<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Traits;

trait EnumLabelTrait
{
    public function getLabel(): ?string
    {
        return self::LABELS[$this->name] ?? null;
    }

    public static function findByLabel(mixed $value): ?self
    {
        $labelsFlipped = array_flip(self::LABELS);

        $value = $labelsFlipped[$value] ?? null;

        $resultEnum = null;
        if ($value !== null) {
            $resultEnum = self::from($value);
        }

        return $resultEnum;
    }

    public static function findLabelByValue(mixed $value): ?string
    {
        $result = array_search(
            needle: self::prepareStringForSearch($value),
            haystack: array_map(fn($value) => self::prepareStringForSearch($value), self::LABELS)
        );

        return $result === false ? null : $result;
    }

    private static function prepareStringForSearch(string $string): string
    {
        $string = str_replace(' ', '', $string);

        return mb_strtolower($string);
    }
}
