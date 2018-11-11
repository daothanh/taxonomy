<?php

namespace Modules\Taxonomy\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Term extends Model
{
    use Translatable, MediaRelation;

    protected $table = 'taxonomy__terms';

    public $translatedAttributes = [
    'name',
    'description',
    'slug',
    'meta_title',
    'meta_description',
    'og_title',
    'og_description',
    'og_image',
    'og_type',
  ];

    protected $fillable = ['pos', 'status', 'vocabulary_id'];

    public function getFeaturedImageAttribute()
    {
        return $this->filesByZone('featured_image')->first();
    }

    public function getIconAttribute()
    {
        return $this->filesByZone('icon')->first();
    }

    public function parents()
    {
        return $this->belongsToMany('Modules\Taxonomy\Entities\Term', 'taxonomy__terms_hierarchy', 'term_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany('Modules\Taxonomy\Entities\Term', 'taxonomy__terms_hierarchy', 'parent_id', 'term_id');
    }

    public function vocabulary()
    {
    	return $this->belongsTo(Vocabulary::class, 'vocabulary_id', 'id');
    }

    public function termableEntites($entity) {
	    return $this->morphedByMany($entity, 'termable');
    }

    public function setStatusAttribute($value)
    {
    	if (empty($value)) {
    		$value = 0;
	    }
    	$this->attributes['status'] = $value;
    }
}
