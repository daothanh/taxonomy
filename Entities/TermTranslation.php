<?php

namespace Modules\Taxonomy\Entities;

use Illuminate\Database\Eloquent\Model;

class TermTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name',
    'description',
    'slug',
    'meta_title',
    'meta_description',
    'og_title',
    'og_description',
    'og_image',
    'og_type',];
    protected $table = 'taxonomy__term_translations';
}
