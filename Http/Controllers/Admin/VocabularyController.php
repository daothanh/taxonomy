<?php

namespace Modules\Taxonomy\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Taxonomy\Entities\Vocabulary;
use Modules\Taxonomy\Http\Requests\CreateVocabularyRequest;
use Modules\Taxonomy\Http\Requests\UpdateVocabularyRequest;
use Modules\Taxonomy\Repositories\VocabularyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class VocabularyController extends AdminBaseController
{
    /**
     * @var VocabularyRepository
     */
    private $vocabulary;

    public function __construct(VocabularyRepository $vocabulary)
    {
        parent::__construct();

        $this->vocabulary = $vocabulary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $vocabularies = $this->vocabulary->all();

        return view('taxonomy::admin.vocabularies.index', compact('vocabularies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('taxonomy::admin.vocabularies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateVocabularyRequest $request
     * @return Response
     */
    public function store(CreateVocabularyRequest $request)
    {
        $this->vocabulary->create($request->all());

        return redirect()->route('admin.taxonomy.vocabulary.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('taxonomy::vocabularies.title.vocabularies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Vocabulary $vocabulary
     * @return Response
     */
    public function edit(Vocabulary $vocabulary)
    {
        return view('taxonomy::admin.vocabularies.edit', compact('vocabulary'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Vocabulary $vocabulary
     * @param  UpdateVocabularyRequest $request
     * @return Response
     */
    public function update(Vocabulary $vocabulary, UpdateVocabularyRequest $request)
    {
        $this->vocabulary->update($vocabulary, $request->all());

        return redirect()->route('admin.taxonomy.vocabulary.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('taxonomy::vocabularies.title.vocabularies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vocabulary $vocabulary
     * @return Response
     */
    public function destroy(Vocabulary $vocabulary)
    {
        $this->vocabulary->destroy($vocabulary);

        return redirect()->route('admin.taxonomy.vocabulary.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('taxonomy::vocabularies.title.vocabularies')]));
    }
}
