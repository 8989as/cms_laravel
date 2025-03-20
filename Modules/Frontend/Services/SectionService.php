<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Repositories\SectionRepository;

class SectionService
{
    protected $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function getSectionWithRelations(string $sectionKey, string $projectKey)
    {
        return $this->sectionRepository->getByKeyAndProjectKey($sectionKey, $projectKey);
    }
}
