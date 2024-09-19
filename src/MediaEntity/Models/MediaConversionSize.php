<?php

namespace Batyukovstudio\BatMedia\MediaEntity\Models;

use Batyukovstudio\BatMedia\MediaEntity\Contracts\HasEntityClassInterface;
use Batyukovstudio\BatMedia\MediaEntity\Enums\MediaFormat;
use Batyukovstudio\BatMedia\MediaEntity\Enums\MediaSize;
use Batyukovstudio\BatMedia\Observers\ClearMediaCacheObserver;
use Illuminate\Database\Eloquent\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * App\Containers\MediaSection\MediaEntity\Models\MediaConversionSize
 *
 * @property int $id
 * @property MediaSize $name
 * @property int $media_entity_conversion_id
 * @property int|null $width
 * @property int|null $height
 * @property int|null $quality
 * @property string|null $description
 * @property-read \App\Containers\MediaSection\MediaEntity\Models\MediaEntityConversion $mediaEntityConversion
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereMediaEntityConversionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaConversionSize whereWidth($value)
 * @property MediaFormat $format
 * @mixin \Eloquent
 */
class MediaConversionSize extends ParentModel implements
    HasEntityClassInterface
{
    /**
     * A resource key to be used in the serialized responses.
     */
    protected $resourceKey = 'mediaConversionSizes';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'media_entity_conversion_id',
        'width',
        'height',
        'quality',
        'description',
    ];
    protected $casts = [
        'format' => MediaFormat::class,
        'name' => MediaSize::class,
    ];

    public static function boot(): void
    {
        parent::boot();

        parent::observe(new ClearMediaCacheObserver);
    }

    public function mediaEntityConversion(): BelongsTo
    {
        return $this->belongsTo(MediaEntityConversion::class);
    }

    public function getMediaEntityConversion(): MediaEntityConversion
    {
        return $this->mediaEntityConversion;
    }

    public function setMediaEntityConversion(MediaEntityConversion $mediaEntityConversion): void
    {
        $this->mediaEntityConversion = $mediaEntityConversion;
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

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(?int $quality): void
    {
        $this->quality = $quality;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getName(): MediaSize
    {
        return $this->name;
    }


    public function getNameValue(): string
    {
        return $this->name->value;
    }


    public function setName(MediaSize $name): void
    {
        $this->name = $name;
    }

    public function getMediaEntityConversionId(): int
    {
        return $this->media_entity_conversion_id;
    }

    public function setMediaEntityConversionId(int $media_entity_conversion_id): void
    {
        $this->media_entity_conversion_id = $media_entity_conversion_id;
    }

    public function getEntityClass(): string
    {
        return $this->getMediaEntityConversion()->getMediaEntity()->getEntityClass();
    }
}
