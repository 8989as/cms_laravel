<?php

namespace Modules\Projects\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FormSubmissionTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // Convert file paths in form_data to full URLs
        $formData = $this->form_data;

        if (is_array($formData)) {
            array_walk_recursive($formData, function (&$item) {
                if (is_string($item) && $this->isFilePath($item)) {
                    $item = Storage::disk('projects_assets')->url($item);
                }
            });
        }

        return [
            'id' => $this->id,
            'section_id' => $this->section_id,
            'form_data' => $formData,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

    /**
     * Check if a string represents a valid file path.
     *
     * @param string $path
     * @return bool
     */
    private function isFilePath($path)
    {
        // Return true for relative paths that are intended to be files
        return !empty($path) && Storage::disk('projects_assets')->exists($path);
    }
}
