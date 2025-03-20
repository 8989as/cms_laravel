<?php

namespace Modules\Base\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseTransformer extends JsonResource
{
    /**
     * BaseTransformer constructor.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Add common transformation logic here for all transformers.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // By default, return the resource as an array
        return parent::toArray($request);
    }
}