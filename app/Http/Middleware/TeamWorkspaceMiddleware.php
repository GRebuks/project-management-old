<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response;

class TeamWorkspaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector|mixed|Response
     */
    public function handle($request, Closure $next): mixed
    {
        $teamId = $request->route('id');
        $team = Team::find($teamId);
        $user = $request->user();
        if (!$team || !$team->belongsToTeam($user->id)) {
            return abort(403, 'You are not authorized to access this workspace.');
        }
        return $next($request);
    }
}
