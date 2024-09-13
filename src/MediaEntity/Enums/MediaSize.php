<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Enums;

use Batyukovstudio\BatMedia\MediaEntity\Traits\EnumLabelTrait;
use Batyukovstudio\BatMedia\Parents\Enums\ParentEnumInterface;

enum MediaSize: string implements ParentEnumInterface
{
    use EnumLabelTrait;

    public const EXTRA_SMALL_TITLE = 'EXTRA_SMALL';
    public const SMALL_TITLE = 'SMALL';
    public const MEDIUM_TITLE = 'MEDIUM';
    public const LARGE_TITLE = 'LARGE';
    public const EXTRA_LARGE_TITLE = 'EXTRA_LARGE';
    public const XX_LARGE_TITLE = '2XL';
    public const XXX_LARGE_TITLE = '3XL';


    case EXTRA_SMALL = 'EXTRA_SMALL';
    case SMALL = 'SMALL';
    case MEDIUM = 'MEDIUM';
    case LARGE = 'LARGE';
    case EXTRA_LARGE = 'EXTRA_LARGE';
    case XX_LARGE = '2XL';
    case XXX_LARGE = '3XL';

    const LABELS = [
        self::EXTRA_SMALL->name => 'EXTRA_SMALL',
        self::SMALL->name => 'SMALL',
        self::MEDIUM->name => 'MEDIUM',
        self::LARGE->name => 'LARGE',
        self::EXTRA_LARGE->name => 'EXTRA_LARGE',
        self::XX_LARGE->name => '2XL',
        self::XXX_LARGE->name => '3XL',
    ];

}