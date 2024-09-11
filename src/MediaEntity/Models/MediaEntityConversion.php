<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Models;

use BatyukovStudio\BatMedia\MediaEntity\Enums\MediaFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Containers\MediaSection\MediaEntity\Models\MediaEntityConversion
 *
 * @property int $id
 * @property string $name
 * @property int $media_entity_id
 * @property string|null $description
 * @property-read Collection<int, \App\Containers\MediaSection\MediaEntity\Models\MediaConversionSize> $mediaConversionSizes
 * @property-read int|null $media_conversion_sizes_count
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereMediaEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereName($value)
 * @property-read \App\Containers\MediaSection\MediaEntity\Models\MediaEntity $mediaEntity
 * @property bool $gallery
 * @property int|null $queued
 * @property int|null $width
 * @property int|null $height
 * @property bool|null $quality
 * @property MediaFormat|null $format
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereGallery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereQueued($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntityConversion whereWidth($value)
 * @mixin \Eloquent
 */
class MediaEntityConversion extends ParentModel
{
    /**
     * A resource key to be used in the serialized responses.
     */
    protected $resourceKey = 'MediaEntityConversion';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'media_entity_id',
        'width',
        'height',
        'quality',
        'format',
        'queued',
        'gallery'
    ];

    protected $casts = [
        'format' => MediaFormat::class,
        'gallery' => 'bool',
        'queued' => 'bool',
    ];

    public function mediaEntity(): BelongsTo
    {
        return $this->belongsTo(MediaEntity::class);
    }

    public function getMediaEntity(): MediaEntity
    {
        return $this->mediaEntity;
    }

    public function mediaConversionSizes(): HasMany
    {
        return $this->hasMany(MediaConversionSize::class);
    }

    public function getMediaConversionSizes(): Collection
    {
        return $this->mediaConversionSizes;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMediaEntityId(): int
    {
        return $this->media_entity_id;
    }

    public function setMediaEntityId(int $media_entity_id): void
    {
        $this->media_entity_id = $media_entity_id;
    }

    public function getFormat(): ?MediaFormat
    {
        return $this->format;
    }

    public function getFormatValue(): ?string
    {
        return $this->format?->value;
    }


    public function setFormat(?MediaFormat $format): void
    {
        $this->format = $format;
    }

    public function isQueued(): ?bool
    {
        return $this->queued;
    }

    public function setQueued(?int $queued): void
    {
        $this->queued = $queued;
    }

    public function isGallery(): bool
    {
        return $this->gallery;
    }

    public function setGallery(bool $gallery): void
    {
        $this->gallery = $gallery;
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
}
