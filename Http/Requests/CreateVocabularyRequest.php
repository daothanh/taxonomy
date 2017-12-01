<?php

namespace Modules\Taxonomy\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Illuminate\Validation\Rule;

class CreateVocabularyRequest extends BaseFormRequest
{
    /**
     * Set the translation key prefix for attributes.
     * @var string
     */
    protected $translationsAttributesKey = 'taxonomy::vocabularies.validation.attributes.';

    public function rules()
    {
        return ['machine_name' => ['required', Rule::unique('taxonomy__vocabularies')]];
    }

    public function translationRules()
    {
        return ['name' => 'required'];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
