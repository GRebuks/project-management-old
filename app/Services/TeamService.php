<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamUserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeamService {

    /**
     * Create a new team with the specified owner.
     *
     * @param User $owner
     * @param string $name
     * @param string $description
     * @param bool $public
     * @return Team
     */
    public function createTeam(User $owner, string $name, string $description = '', bool $public = true): Team
    {
        $team = new Team([
            'name' => $name,
            'description' => $description,
            'is_public' => $public,
        ]);

        $team->owner()->associate($owner);

        $team->save();

        return $team;
    }

    /**
     * Adds a participant to a team
     *
     * @param User $user
     * @param Team $team
     * @param TeamUserRole $role
     */
    public function addParticipant(User $user, Team $team, TeamUserRole $role): void
    {
        $team->participants()->attach($user, ['role_id' => $role->id]);
    }
}
