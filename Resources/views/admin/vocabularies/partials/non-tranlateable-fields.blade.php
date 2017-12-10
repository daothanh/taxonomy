@if(!empty($vocabulary) && !$vocabulary->can_change_machine_name)
    {!! Form::normalInput('machine_name_disabled', trans('taxonomy::vocabularies.form.machine name'), $errors, $vocabulary, ['disabled' => 'disabled']) !!}
    {!! Form::hidden('machine_name', $vocabulary->machine_name) !!}
@else
    {!! Form::normalInput('machine_name', trans('taxonomy::vocabularies.form.machine name'), $errors, $vocabulary) !!}
@endif