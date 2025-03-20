<?php

namespace Modules\Projects\Services;

use Modules\Base\Services\BaseService;
use Modules\Projects\Repositories\ProjectRepository;
use Modules\Projects\Transformers\ProjectTransformer;
class ProjectService extends BaseService
{
    public function __construct(ProjectRepository $repository)
    {
        parent::__construct($repository, ProjectTransformer::class);
    }

}