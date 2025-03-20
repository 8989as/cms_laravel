<?php

namespace Modules\Projects\Repositories;

use Modules\Base\Repositories\BaseRepository;
use Modules\Projects\App\Models\Asset;

class AssetRepository extends BaseRepository
{
    public function __construct(Asset $model)
    {
        parent::__construct($model);
    }

    public function getWhere(array $conditions)
    {
        return $this->model->where($conditions)->get();
    }
}
