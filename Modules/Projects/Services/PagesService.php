<?php

namespace Modules\Projects\Services;
use Modules\Base\Services\BaseService;
use Modules\Projects\Transformers\PageTransformer;
use Modules\Projects\Repositories\PagesRepository;

class PagesService extends BaseService
{
    public function __construct(PagesRepository $repository)
    {
        parent::__construct($repository, PageTransformer::class);
    }
}
