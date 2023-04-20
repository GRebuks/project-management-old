<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkspaceController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();
        $type = request()->type;
        $id = request()->id;
        $workspace = null;
        if ($type === 'team') {
            $team = $this->teamService->getTeamById($id);
            if ($team === null) {
                abort(404);
            }
            if($this->teamService->isUserMemberOfTeam($user, $team)) {
                return view('workspace.index');
            }
            else {
                abort(404);
            }
        }
        else if ($type === 'user') {
            if ((int)$id === $user->id) {
                return view('workspace.index');
            }
            else {
                abort(404);
            }
        }
        else {
            abort(404);
        }
    }

}
