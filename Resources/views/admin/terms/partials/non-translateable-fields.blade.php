{!! Form::hidden('vocabulary_id', $vocabulary->id) !!}
@mediaSingle('featured_image', $term)
{!! Form::normalSelect('parent_ids', trans('taxonomy::terms.form.parent'), $errors, $parentTerms, $term) !!}
{!! Form::normalInput('pos', trans('taxonomy::terms.form.position'), $errors, $term) !!}
{!! Form::normalSelect('status', trans('taxonomy::terms.form.status') ,$errors, [1 => trans('taxonomy::terms.form.show'), 0 => trans('taxonomy::terms.form.hide')], $term) !!}