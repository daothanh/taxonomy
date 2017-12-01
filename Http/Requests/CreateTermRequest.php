<?php

namespace Modules\Taxonomy\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateTermRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'taxonomy::terms.validation.attributes';

    public function rules()
    {
        return ['pos' => 'required|integer', 'vocabulary_id' => 'required|integer'];
    }

    public function translationRules()
    {
        return ['name' => 'required', 'slug' => 'required'];
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
        return [
            'name.required' => trans('taxonomy::terms.messages.name is required'),
            'slug.required' => trans('taxonomy::terms.messages.slug is required')
            ];
    }
}
