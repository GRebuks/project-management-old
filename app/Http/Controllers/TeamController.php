<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use App\Models\TeamUserRole;
use App\Services\TeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index(): View
    {
        $teams = Team::all();
        return view('teams.index', ['teams' => $teams]);
    }

    public function create(): View {
        return view('teams.create');
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        $this->teamService->createTeam($user, $validated['name'], $validated['description']);
        return redirect(route('teams.index'));
    }

    public function edit(Request $request): View {
        $team_id = $request->id;
        $team = Team::find($team_id);

        if($team && $team->isOwnedByLoggedUser()) {
            return view('teams.edit', [
                'team' => $team,
                'id' => $team_id,
            ]);
        }
        else {
            abort(404);
        }
    }

    public function update(TeamUpdateRequest $request): RedirectResponse {
        $team_id = $request->id;
        $team = Team::find($team_id);
        $team->fill($request->validated());
        $team->save();

        if($team->isOwnedByLoggedUser()) {
            return Redirect::route('teams.edit', ['id' => $team_id])->with('status', 'profile-updated');
        }
        else {
            abort(404);
        }
    }
}
