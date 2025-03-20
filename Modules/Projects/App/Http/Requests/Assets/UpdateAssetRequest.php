<?php

namespace Modules\Projects\App\Http\Requests\Assets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
            'image_key' => 'sometimes|string|unique:assets,image_key,' . $this->route('id') . '|max:50',
            // 'project_id' => 'required|exists:projects,id',
        ];
    }
}
