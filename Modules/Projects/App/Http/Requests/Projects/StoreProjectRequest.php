<?php

namespace Modules\Projects\App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
           'name' => 'required|array',
           'name.en' => 'required|string|max:255',
           'name.ar' => 'required|string|max:255',
           'description' => 'nullable|array',
           'description.en' => 'nullable|string',
           'description.ar' => 'nullable|string',
           'url' => 'nullable|url',
           'key' => 'required|string|unique:projects,key',
           'icon' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
           'pages_number' => 'nullable|integer|min:0',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
