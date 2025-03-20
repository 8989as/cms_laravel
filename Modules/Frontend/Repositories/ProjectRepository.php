<?php

namespace Modules\Frontend\Repositories;

use Modules\Projects\App\Models\Project;

class ProjectRepository
{
    public function getByKeyWithRelations(string $key)
    {
        return Project::with(['pages.sections'])->where('key', $key)->first();
    }
}
