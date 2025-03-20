<?php

namespace Modules\Frontend\Services;

use Modules\Frontend\Repositories\PageRepository;

class PageService
{
    protected $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPageWithRelations(string $pageKey, string $projectKey)
    {
        return $this->pageRepository->getByKeyAndProjectKey($pageKey, $projectKey);
    }
}
