<?php

namespace App\Http\Controllers;

use App\Models\KanbanColumn;
use App\Models\Project;
use App\Models\Task;
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
        $resource = $this->getType();
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
        $resource = $this->getType();
        return view('workspace.projects.create', [
            'type' => $resource,
            'id' => request()->id
        ]);
    }

    /**
     * Updates a project
     * @return View
     */
    public function update(): RedirectResponse {
        $id = request()->id;
        $project_id = request()->project_id;

        $resource = $this->getType();
        $project = Project::find($project_id);

        $project->name = request()->name;
        $project->description = request()->description;
        $project->save();

        return redirect()->route($resource . '.projects.settings', [
            'type' => $resource,
            'project' => $project,
            'project_id' => $project_id,
            'id' => $id
        ])->with('status', 'project-updated');;
    }

    /**
     * Deletes a project
     * @return View
     */
    public function destroy(): RedirectResponse {
        $id = request()->id;
        $project_id = request()->project_id;

        $resource = $this->getType();
        $project = Project::find($project_id);

        $project->delete();

        return redirect()->route($resource . '.projects', [
            'type' => $resource,
            'id' => $id
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

    public function show(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.show', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
    }

    public function edit(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.edit', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
    }

    public function tasks(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        $columns = $project->kanbanColumns;
        return view('workspace.projects.tasks', [
            'type' => $resource,
            'project' => $project,
            'id' => $id,
            'columns' => $columns
        ]);
    }

    public function storeTask(Request $request): RedirectResponse
    {
        //validate info
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'column_id' => 'required'
        ]);

        //store task
        $task = new Task([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'project_id' => request()->project_id,
            'due_date' => $request->input('due_date'),
            'kanban_column_id' => $request->input('column_id')
        ]);

        $task->save();

        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return redirect()->route($resource . '.projects.tasks', [
            'type' => $resource,
            'project' => $project,
            'id' => $id,
            'project_id' => $project_id
        ]);
    }

    public function storeKanbanColumn(Request $request): RedirectResponse
    {
        $project_id = request()->project_id;
        $id = request()->id;
        $type = $this->getType();

        $request->validate([
            'title' => 'required'
        ]);

        $kanbanColumn = new KanbanColumn([
            'title' => $request->input('title'),
            'project_id' => $project_id,
        ]);

        $kanbanColumn->save();
        return redirect()->route($type . '.projects.tasks', [
            'type' => $type,
            'id' => $id,
            'project_id' => $project_id
        ]);
    }

    public function files(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.files', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
    }

    public function calendar(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.calendar', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
    }

    public function notes(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.notes', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
    }

    public function settings(): View
    {
        $id = request()->id;
        $project_id = request()->project_id;
        $resource = $this->getType();
        $project = Project::find($project_id);
        return view('workspace.projects.settings', [
            'type' => $resource,
            'project' => $project,
            'id' => $id
        ]);
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

    /**
     * Returns the type of the resource
     * @return string
     */
    private function getType(): string
    {
        $url = request()->path();
        return explode('/', $url)[0];
    }
}
