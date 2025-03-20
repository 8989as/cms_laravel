<?php

namespace Modules\Projects\Repositories;

use Modules\Base\Repositories\BaseRepository;
use Modules\Projects\App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

   
}