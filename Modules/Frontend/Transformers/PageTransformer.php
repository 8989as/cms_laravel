<?php

namespace Modules\Frontend\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class PageTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'sections' => SectionTransformer::collection($this->whenLoaded('sections')),
        ];
    }
}
