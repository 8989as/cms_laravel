<?php

namespace Modules\Projects\App\Http\Requests\Colors;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hex_code' => 'required|string|max:7',
            'color_key' => 'required|string|unique:colors,color_key|max:50',
        ];
    }
}

