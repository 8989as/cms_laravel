<?php

namespace Modules\Frontend\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class ProjectTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'key' => $this->key,
            'description' => $this->description,
            'icon' => $this->icon ? url("storage/{$this->icon}") : null,
            'pages' => PageTransformer::collection($this->whenLoaded('pages')),
        ];
    }
}
