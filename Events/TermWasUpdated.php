<?php

namespace Modules\Taxonomy\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Taxonomy\Contracts\TermHierarchy;
use Modules\Taxonomy\Entities\Term;
use Modules\Media\Contracts\StoringMedia;

class TermWasUpdated implements StoringMedia, TermHierarchy
{
    use SerializesModels;

    /** @var Term */
    private $term;

    /** @var array */
    private $data;

  /**
   * Create a new event instance.
   *
   * @param \Modules\Taxonomy\Entities\Term $term
   * @param array $data
   */
    public function __construct(Term $term, array $data)
    {
        $this->term = $term;
        $this->data = $data;
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

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->term;
    }
    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
