<?php

namespace Modules\Projects\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Database\factories\ColorFactory;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['hex_code', 'color_key', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    protected static function newFactory()
    {
        return ColorFactory::new ();
    }
}
