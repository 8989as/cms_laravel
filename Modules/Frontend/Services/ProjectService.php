<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Repositories\ProjectRepository;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProjectWithRelations(string $key)
    {
        return $this->projectRepository->getByKeyWithRelations($key);
    }
}
