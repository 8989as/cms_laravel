<?php

namespace Modules\Projects\Repositories;

use Modules\Base\Repositories\BaseRepository;
use Modules\Projects\App\Models\FormSubmission;

class FormSubmissionRepository extends BaseRepository
{
    public function __construct(FormSubmission $model)
    {
        parent::__construct($model);
    }
}
