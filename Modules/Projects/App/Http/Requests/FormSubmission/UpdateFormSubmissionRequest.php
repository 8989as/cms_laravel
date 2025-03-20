<?php

namespace Modules\Projects\App\Http\Requests\FormSubmission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'form_data' => [
                'sometimes',
                'array',
                function ($attribute, $value, $fail) {
                    array_walk_recursive($value, function ($item) use ($fail) {
                        if ($item instanceof \Illuminate\Http\UploadedFile) {
                            if (!in_array($item->getMimeType(), ['image/jpeg', 'image/png', 'application/pdf'])) {
                                $fail("The file {$item->getClientOriginalName()} must be an image (jpeg/png) or a PDF.");
                            }

                            if ($item->getSize() > 2048 * 1024) { // 2 MB limit
                                $fail("The file {$item->getClientOriginalName()} exceeds the size limit of 2 MB.");
                            }
                        }
                    });
                },
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->form_data && is_string($this->form_data)) {
            $this->merge([
                'form_data' => json_decode($this->form_data, true), // Decode JSON string into an array
            ]);
        }
    }
}
