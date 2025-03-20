<?php
namespace Modules\Projects\Transformers;

use Modules\Base\Transformers\BaseTransformer;

class PageTransformer extends BaseTransformer
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'project_id' => $this->project_id,
        ];
    }
}
