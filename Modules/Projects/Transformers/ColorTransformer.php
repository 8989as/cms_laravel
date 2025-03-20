<?php

namespace Modules\Projects\Transformers;

use Modules\Base\Transformers\BaseTransformer;

class ColorTransformer extends BaseTransformer
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'hex_code' => $this->hex_code,
            'color_key' => $this->color_key,
            'project_id' => $this->project_id,
        ];
    }
}
