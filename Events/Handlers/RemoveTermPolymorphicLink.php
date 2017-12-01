<?php

namespace Modules\Taxonomy\Events\Handlers;

use Illuminate\Support\Facades\DB;
use Modules\Taxonomy\Contracts\DeletingTerm;

class RemoveTermPolymorphicLink
{
  public function handle($event = null)
  {
    if ($event instanceof DeletingTerm) {
      DB::table('taxonomy__termables')->where('termable_id', $event->getEntityId())
        ->where('termable_type', $event->getClassName())->delete();
    }
  }
}
