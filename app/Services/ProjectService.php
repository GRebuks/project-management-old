<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Support\Collection;

class ProjectService
{
    public static function getProjectTasks($projectId): Collection
    {
        $project = Project::find($projectId);
        if ($project)
            return $project->tasks;
        else return collect();
    }

}
