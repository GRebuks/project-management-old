<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'due_date',
        'kanban_column_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $table = 'tasks';

    /**
     * Get the project that owns the Task
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the kanbanColumn that owns the Task
     * @return BelongsTo
     */
    public function kanbanColumn(): BelongsTo
    {
        return $this->belongsTo(KanbanColumn::class);
    }
}
