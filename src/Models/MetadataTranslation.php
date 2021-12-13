<?php

namespace InWeb\Metadata\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'keywords',
    ];
}
