<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamUserRole;
use App\Services\TeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
