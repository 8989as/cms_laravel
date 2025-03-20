<?php

namespace Modules\Projects\App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'image_key' => 'required|string|unique:assets,image_key|max:50',
        ];
    }
}
