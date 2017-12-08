<?php
namespace Modules\Taxonomy\Events\Handlers;
use Modules\Taxonomy\Contracts\TermLink;

class HandleTermLink
{
    public function handle($event = null, $data = [])
    {
        if ($event instanceof TermLink) {
            $entity = $event->getEntity();
            $postTerms = array_get($event->getSubmissionData(), 'terms', []);

            foreach ($postTerms as $vid => $terms) {
                $syncList = [];
                foreach ($terms as $fileId) {
                    $syncList[$fileId] = [];
                    $syncList[$fileId]['termable_type'] = get_class($entity);
                    $syncList[$fileId]['order'] = 0;
                }
                $entity->termsByVocabularyId($vid)->sync($syncList);
            }
        }
    }
}