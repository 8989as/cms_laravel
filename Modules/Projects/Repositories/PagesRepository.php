<?php

namespace Modules\Projects\Repositories;
use Modules\Base\Repositories\BaseRepository;
use Modules\Projects\App\Models\Page;

class PagesRepository extends BaseRepository
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }
}
