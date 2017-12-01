<?php
namespace Modules\Taxonomy\Events\Handlers;

use Modules\Taxonomy\Contracts\DeletingTerm;
use Modules\Taxonomy\Contracts\TermHierarchy;
use Modules\Taxonomy\Entities\Term;

class HandleTermHierarchy {
    public function handle($event=null)
    {
        if ($event instanceof TermHierarchy) {
            /** @var Term $entity */
            $entity = $event->getEntity();
            $parentIds = array_get($event->getSubmissionData(), 'parent_ids', []);
            if (!is_array($parentIds)) {
                $parentIds = explode(",", $parentIds);
            }
            $entity->parents()->sync($parentIds);
        }

        if ($event instanceof DeletingTerm) {
            $entity = $event->getEntity();
            $entity->parents()->detach();
        }
    }
}