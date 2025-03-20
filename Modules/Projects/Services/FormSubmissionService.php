<?php

namespace Modules\Projects\Services;

use Modules\Base\Services\BaseService;
use Modules\Projects\Repositories\FormSubmissionRepository;

class FormSubmissionService extends BaseService
{
    public function __construct(FormSubmissionRepository $repository)
    {
        parent::__construct($repository);
    }
}
