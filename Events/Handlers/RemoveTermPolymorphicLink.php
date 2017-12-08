<?php

namespace Modules\Taxonomy\Events\Handlers;

use Illuminate\Support\Facades\DB;
use Modules\Taxonomy\Contracts\DeletingTerm;
use Modules\Taxonomy\Entities\Term;

class RemoveTermPolymorphicLink
{
  public function handle($event = null)
  {
    if ($event instanceof DeletingTerm) {
        $className = $event->getClassName();
        if ($className === Term::class) {
            DB::table('taxonomy__termables')->where('term_id', $event->getEntityId())->delete();
        } else {
            DB::table('taxonomy__termables')->where('termable_id', $event->getEntityId())
                ->where('termable_type', $event->getClassName())->delete();
        }

    }
  }
}
