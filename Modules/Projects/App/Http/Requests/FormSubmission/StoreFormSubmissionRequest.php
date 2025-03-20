<?php

namespace Modules\Projects\App\Http\Requests\FormSubmission;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormSubmissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'section_id' => 'required|exists:sections,id',
            'form_data' => [
                'required',
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

}
