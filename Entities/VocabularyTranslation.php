<?php

namespace Modules\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Model;

class VocabularyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'vocabulary_id', 'locale'];
    protected $table = 'taxonomy__vocabulary_translations';
}
