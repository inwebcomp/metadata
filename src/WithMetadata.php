<?php

namespace InWeb\Metadata;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use InWeb\Metadata\Models\Metadata;

/**
 * @property Metadata|null $metadata
 */
trait WithMetadata
{
    public function metadata(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Metadata::class, 'metadatable');
    }

    /**
     * @param $attributes
     * @return bool
     */
    public function setMetadata($attributes): bool
    {
        if (!($metadata = $this->metadata)) {
            $metadata = new Metadata();

            $metadata->fill($attributes);
            $metadata->metadatable()->associate($this);
        } else {
            $metadata->fill($attributes);
        }

        return $metadata->save();
    }

    public function getMetadata(array $attributes = []): array
    {
        return array_merge(Metadata::forModel($this), $attributes);
    }

    public function getMetaTitle()
    {
        if (isset($this->title))
            return $this->title;

        if (isset($this->name))
            return $this->name;

        return class_basename(static::class) . ' #' . $this->getKey();
    }

    public function getMetaDescription()
    {
        return null;
    }

    public function getMetaKeywords()
    {
        return null;
    }

    public function getMetaImage()
    {
        if (!$this->image)
            return null;

        return $this->image->getUrl();
    }
}
