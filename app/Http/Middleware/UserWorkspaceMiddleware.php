<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response;

class UserWorkspaceMiddleware
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
        $userId = $request->route('id');
        $user = $request->user();
        if ($user->id != $userId) {
            return abort(403, 'You are not authorized to access this workspace.');
        }

        if($request->route('project_id')) {
            $projectId = $request->route('project_id');
            if (!$this->doesProjectBelongToUser($userId, $projectId)) {
                return abort(403, 'You are not authorized to access this project.');
            }
        }

        return $next($request);
    }

    private function doesProjectBelongToUser($userId, $projectId): bool
    {
        $user = User::find($userId);
        if ($user) {
            return $user->projects->contains($projectId);
        }
        return false;
    }
}
