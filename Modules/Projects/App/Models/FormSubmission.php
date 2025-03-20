<?php

namespace Modules\Projects\App\Models;

namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Database\Factories\FormSubmissionFactory;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'form_data'];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'id');
    }

    protected static function newFactory()
    {
        return FormSubmissionFactory::new ();
    }
}
