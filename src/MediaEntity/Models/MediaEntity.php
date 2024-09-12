<?php

namespace BatyukovStudio\BatMedia\MediaEntity\Models;

use BatyukovStudio\BatMedia\MediaEntity\Enums\MediaFormat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as ParentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Containers\MediaSection\MediaEntity\Models\MediaEntity
 *
 * @property int $id
 * @property string $name
 * @property string $entity_class
 * @property string|null $description
 * @property-read Collection<int, \App\Containers\MediaSection\MediaEntity\Models\MediaConversionSize> $mediaEntityConversions
 * @property-read int|null $media_entity_conversions_count
 * @method static \App\Containers\MediaSection\MediaEntity\Data\Factories\MediaEntityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereEntityClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereName($value)
 * @property bool|null $queued
 * @property int|null $width
 * @property int|null $height
 * @property int|null $quality
 * @property MediaFormat|null $format
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereQueued($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaEntity whereWidth($value)
 * @mixin \Eloquent
 */
class MediaEntity extends ParentModel
{
    /**
     * A resource key to be used in the serialized responses.
     */
    protected $resourceKey = 'MediaEntity';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'entity_class',
        'width',
        'height',
        'quality',
        'format',
        'queued',
    ];

    protected $casts = [
        'format' => MediaFormat::class,
        'queued' => 'bool',
    ];

    public function mediaEntityConversions(): HasMany
    {
        return $this->hasMany(MediaEntityConversion::class);
    }

    public function getMediaEntityConversions(): Collection
    {
        return $this->mediaEntityConversions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getEntityClass(): string
    {
        return $this->entity_class;
    }

    public function setEntityClass(string $entityClass): void
    {
        $this->entity_class = $entityClass;
    }

    public function isQueued(): ?bool
    {
        return $this->queued;
    }

    public function setQueued(?bool $queued): void
    {
        $this->queued = $queued;
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

}
