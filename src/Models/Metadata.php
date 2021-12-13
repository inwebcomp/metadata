<?php

namespace InWeb\Metadata\Models;

use InWeb\Base\Entity;
use InWeb\Base\Support\Route;
use InWeb\Base\Traits\BindedToModelAndObject;
use \InWeb\Base\Traits\Translatable;
use InWeb\Metadata\WithMetadata;

/**
 * @property string $title
 * @property string $description
 * @property string $keywords
 */
class Metadata extends Entity
{
    use Translatable;

    public string $translationModel     = MetadataTranslation::class;
    public array  $translatedAttributes = ['title', 'description', 'keywords'];

    public function getTable(): string
    {
        return 'metadata';
    }

    public function metadatable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function toArray(): array
    {
        return array_filter($this->only([
            'title',
            'description',
            'keywords',
        ]), function ($value) {
            return $value;
        });
    }

    /**
     * @param Entity $model
     * @return array
     */
    public static function forModel(Entity $model): array
    {
        /** @var WithMetadata|Entity $model */
        $result = optional($model->metadata)->toArray() ?? [];

        $data = [
            'title'       => $model->getMetaTitle() . ' | ' . config('app.name'),
            'description' => $model->getMetaDescription(),
            'keywords'    => $model->getMetaKeywords(),
        ];

        if (in_array('InWeb\Media\Images\WithImages', class_uses_recursive($model))) {
            $data['og:image'] = $model->getMetaImage();
        }

        return array_merge($data, $result);
    }
}
