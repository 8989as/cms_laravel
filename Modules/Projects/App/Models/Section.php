<?php
namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\App\Models\Page;
use Modules\Projects\Database\factories\SectionFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'key', 'page_id'];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * Relationship: Section indirectly belongs to a project via a page.
     */
    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            Page::class,
            'id',        // Foreign key on the pages table
            'id',        // Foreign key on the projects table
            'page_id',   // Local key on the sections table
            'project_id' // Local key on the pages table
        );
    }

    /**
     * Factory method for testing.
     */
    protected static function newFactory(): SectionFactory
    {
        return SectionFactory::new ();
    }
}
