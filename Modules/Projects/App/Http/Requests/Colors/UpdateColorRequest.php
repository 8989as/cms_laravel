<?php

namespace Modules\Projects\App\Http\Requests\Colors;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hex_code' => 'sometimes|string|max:7',
            'color_key' => 'sometimes|string|unique:colors,color_key,' . $this->route('id') . '|max:50',
        ];
    }
}
