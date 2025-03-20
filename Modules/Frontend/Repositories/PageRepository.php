<?php

namespace Modules\Frontend\Repositories;

use Modules\Projects\App\Models\Page;

class PageRepository
{
    public function getByKeyAndProjectKey(string $pageKey, string $projectKey)
    {
        return Page::with('sections')
            ->where('key', $pageKey)
            ->whereHas('project', function ($query) use ($projectKey) {
                $query->where('key', $projectKey);
            })
            ->first();
    }
}
