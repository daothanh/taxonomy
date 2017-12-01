@if(!empty($vocabulary) && !$vocabulary->can_change_machine_name)
    {!! Form::normalInput('machine_name', trans('taxonomy::vocabularies.form.machine name'), $errors, $vocabulary, ['disabled' => 'disabled']) !!}
@else
    {!! Form::normalInput('machine_name', trans('taxonomy::vocabularies.form.machine name'), $errors, $vocabulary) !!}
@endif