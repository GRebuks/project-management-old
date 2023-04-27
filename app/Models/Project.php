<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'owner_type',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function kanbanColumns()
    {
        return $this->hasMany(KanbanColumn::class);
    }
}
