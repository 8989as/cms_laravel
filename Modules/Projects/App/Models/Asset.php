<?php

namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Database\factories\AssetFactory;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'image_key', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    protected static function newFactory()
    {
        return AssetFactory::new ();
    }
}
