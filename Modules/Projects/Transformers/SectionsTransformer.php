<?php

namespace Modules\Projects\Transformers;

use Modules\Base\Transformers\BaseTransformer;

class SectionsTransformer extends BaseTransformer
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'page_id' => $this->page_id,
        ];
    }
}
