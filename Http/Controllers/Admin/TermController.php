<?php

namespace Modules\Taxonomy\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Taxonomy\Entities\Term;
use Modules\Taxonomy\Http\Requests\CreateTermRequest;
use Modules\Taxonomy\Http\Requests\UpdateTermRequest;
use Modules\Taxonomy\Repositories\TermRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TermController extends AdminBaseController
{
    /**
     * @var TermRepository
     */
    private $term;

    public function __construct(TermRepository $term)
    {
        parent::__construct();

        $this->term = $term;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($vocabulary)
    {
        //dd($vocabulary);
        $terms = $this->term->getTree($vocabulary->id);
        
        return view('taxonomy::admin.terms.index', compact('terms', 'vocabulary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($vocabulary)
    {
        $parentTerms = ['0' => trans('taxonomy::terms.form.select parent')] + $this->term->getByAttributes(['vocabulary_id' => $vocabulary->id])->pluck('name', 'id')->toArray();
        return view('taxonomy::admin.terms.create', compact('vocabulary', 'parentTerms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTermRequest $request
     * @return Response
     */
    public function store($vocabulary, CreateTermRequest $request)
    {
        $this->term->create($request->all());

        return redirect()->route('admin.taxonomy.term.index', [$vocabulary->id])
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('taxonomy::terms.title.terms')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Term $term
     * @return Response
     */
    public function edit(Term $term)
    {
        $parentTerms = ['0' => trans('taxonomy::terms.form.select parent')] + $this->term->getByAttributes(['vocabulary_id' => $term->vocabulary_id])->pluck('name', 'id')->toArray();
        return view('taxonomy::admin.terms.edit', compact('term', 'vocabulary', 'parentTerms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Term $term
     * @param  UpdateTermRequest $request
     * @return Response
     */
    public function update($vocabulary, Term $term, UpdateTermRequest $request)
    {
        $this->term->update($term, $request->all());

        return redirect()->route('admin.taxonomy.term.index', ['vocabulary' => $vocabulary->id])
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('taxonomy::terms.title.terms')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Term $term
     * @return Response
     */
    public function destroy($vocabulary, Term $term)
    {
        $this->term->destroy($term);

        return redirect()->route('admin.taxonomy.term.index', ['vocabulary' => $vocabulary->id])
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('taxonomy::terms.title.terms')]));
    }
}
