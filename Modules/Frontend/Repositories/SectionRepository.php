<?php

namespace Modules\Frontend\Repositories;

use Modules\Projects\App\Models\Section;

class SectionRepository
{
    public function getByKeyAndProjectKey(string $sectionKey, string $projectKey)
    {
        return Section::with('page.project')
            ->where('key', $sectionKey)
            ->whereHas('page.project', function ($query) use ($projectKey) {
                $query->where('key', $projectKey);
            })
            ->first();
    }
}
