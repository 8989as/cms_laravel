<?php

namespace Modules\Projects\App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|array|max:255',
            'description' => 'nullable|array',
            'project_id' => 'required|exists:projects,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
