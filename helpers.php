<?php

use \Illuminate\Database\Eloquent\Builder;
use \Modules\Taxonomy\Entities\Term;
use \Modules\Taxonomy\Repositories\TermRepository;
use \Modules\Taxonomy\Repositories\Eloquent\EloquentTermRepository;
use \Modules\Taxonomy\Repositories\VocabularyRepository;
use \Modules\Taxonomy\Entities\Vocabulary;

/**
 * Get term repository
 *
 * @return EloquentTermRepository|mixed
 */
function taxonomy_term_repository()
{
    return app(TermRepository::class);
}

/**
 * Get a list of terms that was make hierarchical tree
 *
 * @param $vid
 * @param int $parent
 * @param null $maxDepth
 *
 * @return array
 */
function taxonomy_get_tree($vid, $parent = 0, $maxDepth = null)
{
    return taxonomy_term_repository()->getTree($vid, $parent, $maxDepth);
}

/**
 * Get a term by id
 * @param int $tid
 *
 * @return Term|null
 */
function taxonomy_get_term($tid)
{
    return taxonomy_term_repository()->find($tid);
}

/**
 * Get a term by slug
 * @param $slug
 *
 * @return Term|null
 */
function taxonomy_get_term_by_slug($slug)
{
    return taxonomy_term_repository()->findBySlug($slug);
}

/**
 * Update or create a new term
 *
 * @param Term $term
 *
 * @param array $data
 *
 * @return \Modules\Taxonomy\Entities\Term|null
 */
function taxonomy_term_save(Term $term, array $data)
{
    $repository = taxonomy_term_repository();
    if ($term->id) {
        $term = $repository->update($term, $data);
    } else {
        $term = $repository->create($data);
    }
    return $term;
}

/**
 * Get repository of vocabulary
 *
 * @return \Modules\Taxonomy\Repositories\Eloquent\EloquentVocabularyRepository
 */
function taxonomy_vocabulary_repository()
{
    return app(VocabularyRepository::class);
}

/**
 * Get a vocabulary by id
 *
 * @param int $vid
 *
 * @return mixed
 */
function taxonomy_get_vocabulary($vid)
{
    return taxonomy_vocabulary_repository()->find($vid);
}

/**
 * Get a vocabulary by machine name
 * @param string $machineName
 * @return Vocabulary|null
 */
function taxonomy_get_vocabulary_by_machine_name($machineName)
{
    return taxonomy_vocabulary_repository()->findByAttributes(['machine_name' => $machineName]);
}

/**
 * Get all vocabularies
 */
function taxonomy_get_vocabularies()
{
    return taxonomy_vocabulary_repository()->all();
}

/**
 * Update or create a new vocabulary
 *
 * @param \Modules\Taxonomy\Entities\Vocabulary $vocabulary
 * @param array $data
 *
 * @return mixed
 */
function taxonomy_vocabulary_save(Vocabulary $vocabulary, array $data)
{
    $repository = taxonomy_vocabulary_repository();
    if ($vocabulary->id) {
        $vocabulary = $repository->update($vocabulary, $data);
    } else {
        $vocabulary = $repository->create($data);
    }
    return $vocabulary;
}

/**
 * Destroy an vocabulary by id
 * @param $vid
 *
 * @return bool
 */
function taxonomy_vocabulary_delete($vid)
{
    $repository = taxonomy_vocabulary_repository();
    $vocabulary = $repository->find($vid);
    if ($vocabulary) {
        return $repository->destroy($vocabulary);
    }
    return false;
}
