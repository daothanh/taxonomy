<?php

namespace Modules\Taxonomy\Repositories\Eloquent;

use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Events\TermWasCreated;
use Modules\Taxonomy\Events\TermWasDeleted;
use Modules\Taxonomy\Events\TermWasUpdated;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTermRepository extends EloquentBaseRepository implements TermRepository
{
  /** @var  Term $model */
    protected $model;
    /**
     * Create a term
     *
     * @param $data
     * @return $this|Term
     */
    public function create($data)
    {
        /** @var Term $term */
        $term = $this->model->create($data);

        event(new TermWasCreated($term, $data));
        return $term;
    }

    /**
     * Update a term
     *
     * @param Term $term
     * @param array $data
     * @return mixed
     */
    public function update($term, $data)
    {
        $term->update($data);

        event(new TermWasUpdated($term, $data));
        return $term;
    }

    /**
     * Delete a term
     *
     * @param Term $term
     * @return mixed
     * @throws \Exception
     */
    public function destroy($term)
    {
        event(new TermWasDeleted($term));
        return $term->delete();
    }

  /**
   * @param int $id
   *
   * @return Term|null
   */
    public function find($id)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->find($id);
        }

        return $this->model->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {
        $query = $this->model->query();
        if (method_exists($this->model, 'translations')) {
            $query = $query->with('translations');
        }
        return $query;
    }

    /**
     * @param int $vid
     * @param \Illuminate\Database\Eloquent\Collection|Term[] $items
     * @param $parent
     * @param null $maxDepth
     * @return array
     */
    public function createTree($vid, $items, $parent, $maxDepth = null)
    {
        $tree = array();
        if (isset($items) && $items->isNotEmpty()) {
            $children = [];
            $parents = [];
            $terms = [];

            foreach ($items as $term) {
                $children[$vid][$term->parent][] = $term->id;
                $parents[$vid][$term->id][] = $term->parent;
                $terms[$vid][$term->id] = $term;
            }
          //dd($terms);
            $max_depth = (!isset($max_depth)) ? count($children[$vid]) : $max_depth;

          // Keeps track of the parents we have to process, the last entry is used
          // for the next processing step.
            $process_parents = array();
            $process_parents[] = $parent;

          // Loops over the parent terms and adds its children to the tree array.
          // Uses a loop instead of a recursion, because it's more efficient.
            while (count($process_parents)) {
                $parent = array_pop($process_parents);
              // The number of parents determines the current depth.
                $depth = count($process_parents);
                if ($max_depth > $depth && !empty($children[$vid][$parent])) {
                    $has_children = false;
                    $child = current($children[$vid][$parent]);
                    do {
                        if (empty($child)) {
                            break;
                        }
                        $term = $terms[$vid][$child];
                        if (isset($parents[$vid][$term->id])) {
                          // Clone the term so that the depth attribute remains correct
                          // in the event of multiple parents.
                            $term = clone $term;
                        }
                        $term->depth = $depth;
                        unset($term->parent);
                      //$term->parentIds = $parents[$vid][$term->id];
                        $tree[] = $term;
                        if (!empty($children[$vid][$term->id])) {
                            $has_children = true;

                          // We have to continue with this parent later.
                            $process_parents[] = $parent;
                          // Use the current term as parent for the next iteration.
                            $process_parents[] = $term->id;

                          // Reset pointers for child lists because we step in there more often
                          // with multi parents.
                            reset($children[$vid][$term->id]);
                          // Move pointer so that we get the correct term the next time.
                            next($children[$vid][$parent]);
                            break;
                        }
                    } while ($child = next($children[$vid][$parent]));

                    if (!$has_children) {
                      // We processed all terms in this hierarchy-level, reset pointer
                      // so that this function works the next time it gets called.
                        reset($children[$vid][$parent]);
                    }
                }
            }
        }

        return $tree;
    }

    /**
     * Return full tree of terms
     *
     * @param int $vid Vocabulary ID
     * @param int $parent Identity of parent term
     * @param null $maxDepth
     * @return array
     */
    public function getTree($vid, $parent = 0, $maxDepth = null)
    {
        $items = $this->getQuery()->select([
        'taxonomy__terms.*',
        'taxonomy__terms_hierarchy.parent_id as parent',
        ])->leftJoin('taxonomy__terms_hierarchy', 'id', '=', 'term_id')
        ->where('vocabulary_id', '=', $vid)
        ->orderBy('pos', 'asc')->get();
        
        return $this->createTree($vid, $items, $parent, $maxDepth);
    }
}
