<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $url = request()->path();
        $resource = explode('/', $url)[0];
        $id = request()->id;

        if ($resource == 'users')
            $projects = $this->getProjectsForUser($id);
        else if ($resource == 'teams')
            $projects = $this->getProjectsForTeam($id);
        else
            $projects = collect();

        return view('workspace.projects.index', [
            'type' => $resource,
            'projects' => $projects,
            'id' => request()->id
        ]);
    }

    /**
     * Shows a specific project in detail
     * @param $user_id
     * @return Collection
     */
    private function getProjectsForUser($user_id): Collection
    {
        $user = User::find($user_id);
        if ($user) {
            return $user->projects;
        }
        return collect();
    }

    /**
     * Shows a specific project in detail
     * @param $team_id
     * @return Collection
     */
    private function getProjectsForTeam($team_id): Collection
    {
        $team = Team::find($team_id);
        if ($team) {
            return $team->projects;
        }
        return collect();
    }

    /**
     * Shows the form to create a new project
     * @return View
     */
    public function create(): View
    {
        $url = request()->path();
        $resource = explode('/', $url)[0];

        return view('workspace.projects.create', [
            'type' => $resource,
            'id' => request()->id
        ]);
    }

    /**
     * Stores a new project
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $id = $request->input('id');
        $type = $request->input('type');

        if ($type == 'users') {
            $this->storeForUser($request, $id);
            return redirect()->route('users.workspace', ['id' => $id]);
        }
        else if ($type == 'teams') {
            $project = $this->storeForTeam($request, $id);
            $user = auth()->user();
            NotificationService::sendNotification($user, $project, 'Project creation','A new project has been created', 'New project');
            return redirect()->route('teams.workspace', ['id' => $id]);
        }
        else {
            return redirect()->route('dashboard');
        }
    }

    private function storeForTeam(Request $request, $team_id): Project
    {
        $project = new Project([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'owner_id' => $team_id,
            'owner_type' => 'App\Models\Team'
        ]);

        $project->save();
        return $project;
    }

    private function storeForUser(Request $request, $user_id) {
        $project = new Project([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'owner_id' => $user_id,
            'owner_type' => 'App\Models\User'
        ]);

        $project->save();
    }
}
