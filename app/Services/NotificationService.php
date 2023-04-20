<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Support\Collection;

class NotificationService
{
    public static function sendNotification($user, $project, $action, $message, $title = "New activity"): void
    {
        $notification = new Notification([
            'title' => $title,
            'message' => $message,
            'user_id' => $user->id,
            'project_id' => $project->id,
            'type' => $action,
        ]);

        $notification->save();
    }

    public static function getProjectNotifications($projectId): Collection
    {
        $project = Project::find($projectId);
        if ($project)
            return Notification::where('project_id', $projectId)->get();
        else return collect();
    }

    public static function getTeamNotifications($teamId): Collection
    {
        $team = Team::find($teamId);
        if (!$team)
            return collect();

        try {
            return Notification::whereIn('project_id', $team->projects->pluck('id'))->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
}
