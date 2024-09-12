<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Enums;

enum MediaFormat: string
{
    case WEBP = 'webp';
    case PNG = 'png';
    case JPG = 'jpg';
    case SVG = 'svg';
    case AVIF = 'avif';

    public const LABELS = [
        self::WEBP->value => 'webp',
        self::PNG->value => 'png',
        self::JPG->value => 'jpg',
        self::SVG->value => 'svg',
        self::AVIF->value => 'avif',
    ];

}