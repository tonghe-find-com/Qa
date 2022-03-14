<?php

namespace TypiCMS\Modules\Qas\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class FormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'title.*' => 'nullable|max:255',
            'status.*' => 'boolean',
            'body.*' => 'nullable',
            'category_id' => 'integer',
        ];
    }
}
