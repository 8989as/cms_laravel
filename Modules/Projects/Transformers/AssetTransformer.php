<?php

namespace Modules\Projects\Transformers;

use Modules\Base\Transformers\BaseTransformer;

class AssetTransformer extends BaseTransformer
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => url("/storage/{$this->image}"),
            'image_key' => $this->image_key,
            'project_id' => $this->project_id,
        ];
    }
}

