<?php
namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\App\Models\Project;
use Modules\Projects\Database\factories\PageFactory;

class Page extends Model
{
    use HasFactory;

    protected $table      = 'pages';
    protected $primaryKey = 'id';
    protected $fillable   = ['name', 'description', 'key', 'project_id'];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    /**
     * Relationship: Page has many sections.
     */
    public function sections()
    {
        return $this->hasMany(Section::class, 'page_id', 'id');
    }

    /**
     * Factory method for testing.
     */
    protected static function newFactory(): PageFactory
    {
        return PageFactory::new ();
    }
}
