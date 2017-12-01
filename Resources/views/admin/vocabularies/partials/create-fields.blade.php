<div class="box-body">
    {!! Form::i18nInput('name', trans('taxonomy::vocabularies.form.name'), $errors, $lang, $vocabulary) !!}
    {!! Form::i18nTextarea('description', trans('taxonomy::vocabularies.form.description'), $errors, $lang, $vocabulary, ['class' => 'form-control']) !!}
</div>
