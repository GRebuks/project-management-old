<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamUpdateRequest;
use App\Models\Notification;
use App\Models\Team;
use App\Models\TeamUserRole;
use App\Models\User;
use App\Services\NotificationService;
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

    public function participating(): View
    {
        $user = Auth::user();
        $ownedTeams = $this->teamService->getOwnedTeams($user);
        $memberTeams = $this->teamService->getMemberTeams($user);
        return view('teams.participating', compact('user', 'ownedTeams', 'memberTeams'));
    }

    /**
     * Shows a specific team in detail
     * @return View
     */
    public function show(): View {
        $team_id = request()->id;
        $team = Team::find($team_id);

        if($team && $team->isOwnedByLoggedUser()) {
            return view('teams.show', [
                'team' => $team,
                'id' => $team_id,
            ]);
        }
        else {
            abort(404);
        }
    }

    /**
     * Shows the form to create a new team
     * @return View
     */
    public function create(): View {
        return view('teams.create');
    }

    /**
     * Stores a new team in the database
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:255'
        ]);

        $user = Auth::user();

        $this->teamService->createTeam($user, $validated['name'], $validated['description']);
        return redirect(route('teams.index'));
    }

    /**
     * Shows the form to edit a team
     * @param Request $request
     * @return View
     */
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

    /**
     * Updates a team in the database
     * @param TeamUpdateRequest $request
     * @return RedirectResponse
     */
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

    /**
     * Deletes a team from the database
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse {
        $request->validateWithBag('teamDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $team_id = $request->id;
        $team = Team::find($team_id);

        $team->delete();

        return Redirect::to('/teams');
    }

    /**
     * Adds a user to a team
     * @param $team_id
     * @return RedirectResponse
     */
    public function joinTeam($team_id): RedirectResponse
    {
        $team = Team::find($team_id);
        $this->teamService->addParticipant(Auth::user(), $team);
        return redirect()->route('teams.index');
    }

    /**
     * Removes a user from a team
     * @param $team_id
     * @return RedirectResponse
     */
    public function leaveTeam($team_id): RedirectResponse
    {
        $team = Team::find($team_id);
        $this->teamService->removeParticipant(Auth::user(), $team);
        return redirect()->route('teams.index');
    }

    public function showWorkspace(): View
    {
        $team_id = request()->id;
        $team = Team::find($team_id);
        if($team && $team->belongsToTeam()) {
            return view('workspace.index', [
                'team' => $team,
                'id' => $team_id,
            ]);
        }
        else {
            abort(403);
        }
    }
}
