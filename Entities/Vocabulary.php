<?php

namespace Modules\Taxonomy\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use Translatable;

    protected $table = 'taxonomy__vocabularies';
    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['machine_name', 'can_change_machine_name'];

    public function terms()
    {
    	return $this->hasMany(Term::class, 'vocabulary_id', 'id');
    }
}
