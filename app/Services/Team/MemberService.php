<?php

namespace App\Services\Team;

use App\Exceptions\Team\UserIsTeamOwnerException;
use App\Models\Team\Team;
use App\Models\User;
use App\Notifications\DetachedFromTeam;
use Illuminate\Support\Facades\DB;

class MemberService
{
    public function attachUser(User $user, Team $team): void
    {
        DB::transaction(function () use ($user, $team) {
            $team->members()->attach($user);
            $user->update(['current_team_id' => $team->getKey()]);
        });
    }

    public function detachUser(User $user, Team $team): void
    {
        if ($team->isOwner($user->getKey())) {
            throw new UserIsTeamOwnerException('Can not detach a team owner');
        }

        DB::transaction(function () use ($user, $team) {
            $team->members()->detach($user);
            $user->update(['current_team_id' => null]);
        });

        $user->notify(new DetachedFromTeam($team->getAttribute('name')));
    }
}
