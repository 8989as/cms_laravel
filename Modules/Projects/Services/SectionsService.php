<?php

namespace Modules\Projects\Services;

use Modules\Base\Services\BaseService;
use Modules\Projects\Repositories\SectionsRepository;
use Modules\Projects\Transformers\SectionsTransformer;

class SectionsService extends BaseService
{
    public function __construct(SectionsRepository $repository)
    {
        parent::__construct($repository, SectionsTransformer::class);
    }

    public function getWhere(array $conditions)
    {
        return $this->repository->getWhere($conditions);
    }
}
