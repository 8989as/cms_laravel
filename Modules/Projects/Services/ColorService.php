<?php

namespace Modules\Projects\Services;

use Modules\Base\Services\BaseService;
use Modules\Projects\Repositories\ColorRepository;
use Modules\Projects\Transformers\ColorTransformer;

class ColorService extends BaseService
{
    public function __construct(ColorRepository $repository)
    {
        parent::__construct($repository, ColorTransformer::class);
    }

    public function getWhere(array $conditions)
    {
        return $this->repository->getWhere($conditions);
    }
}
