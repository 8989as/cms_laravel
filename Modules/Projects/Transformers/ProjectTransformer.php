<?php

namespace Modules\Projects\Transformers;

use Modules\Base\Transformers\BaseTransformer;
use Illuminate\Support\Facades\Storage;

class ProjectTransformer extends BaseTransformer
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'key' => $this->key,
            'description' => $this->description,
            'icon' => $this->icon ? url("/storage/{$this->icon}") : null,
            'pages_number' => $this->pages_number,
        ];
    }
}