<?php
namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'url',
        'key',
        'description',
        'icon',
        'pages_number',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
    ];

    /**
     * Translatable attributes.
     */
    public $translatable = ['name', 'description'];

    /**
     * Relationship: Project has many pages.
     */
    public function pages()
    {
        return $this->hasMany(Page::class, 'project_id', 'id');
    }

    public static function newFactory()
    {
        return \Modules\Projects\Database\Factories\ProjectFactory::new ();
    }
}
