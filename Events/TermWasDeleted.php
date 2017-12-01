<?php

namespace Modules\Taxonomy\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Taxonomy\Contracts\DeletingTerm;
use Modules\Taxonomy\Entities\Term;
use Modules\Media\Contracts\DeletingMedia;

class TermWasDeleted implements DeletingMedia, DeletingTerm
{
    use SerializesModels;

    /** @var Term */
    private $term;

  /**
   * Create a new event instance.
   *
   * @param \Modules\Taxonomy\Entities\Term $term
   */
    public function __construct(Term $term)
    {
        $this->term = $term;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function getEntity()
    {
        return $this->term;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->term->id;
    }
    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return get_class($this->term);
    }
}
