<?php

namespace Modules\Projects\Services;

use Modules\Base\Services\BaseService;
use Modules\Projects\Repositories\AssetRepository;
use Modules\Projects\Transformers\AssetTransformer;

class AssetService extends BaseService
{
    public function __construct(AssetRepository $repository)
    {
        parent::__construct($repository, AssetTransformer::class);
    }

    public function getWhere(array $conditions)
    {
        return $this->repository->getWhere($conditions);
    }
}
