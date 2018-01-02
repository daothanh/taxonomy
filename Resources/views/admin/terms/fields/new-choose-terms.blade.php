<div class="box">
    <div class="box-header">
        <h2 class="box-title">{{ !empty($vocabulary) ? $vocabulary->name : trans('taxonomy::terms.form.terms') }}</h2>
    </div>
    <div class="box-body">
        @if($terms)
            <div>
                @forelse($terms as $key => $term)
                    <div class="checkbox-{{$term->id}}">
                        {{str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $term->depth)}}
                        <label>
                            <div class="icheckbox">
                                {{Form::checkbox('term_ids['.$vid.']['.$term->id.']',$term->id, $entityTerms && $entityTerms->find($term->id) ? TRUE: FALSE, ['class' => 'terms'])}}
                                {{$term->name}}
                            </div>
                        </label>
                    </div>
                @empty
                    <li>
                        <a href="{{ route('taxonomy.admin.terms.index') }}">{{ trans('taxonomy::terms.form.add term') }}</a>
                    </li>
                @endforelse
            </div>
        @endif
    </div>
    <div class="box-footer">

    </div>
</div>