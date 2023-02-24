<?php

namespace App\Http\Controllers\Team;

use App\Exceptions\Team\UserIsTeamOwnerException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\InviteStoreRequest;
use App\Models\Team\Invite;
use App\Models\User;
use App\Notifications\TeamMemberInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    public function store(InviteStoreRequest $request)
    {
        $validated = $request->validated();
        $authName = $request->user()->name;
        $team = $request->user()->currentTeam();

        $invite = $team->invites()->create([
            ...$validated,
            'token' => Str::random(32)
        ]);

        $user = (new User())->fill($validated);

        $user->notify(new TeamMemberInvited(
            name: $authName,
            teamName: $team->name,
            token: $invite->token
        ));

        return redirect()->back();
    }

    public function accept(Request $request, string $token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        $team = $invite->team;
        $user = $request->user();

        if ($user->inTeam($team->getKey())) {
            $invite->delete();

            throw new UserIsTeamOwnerException('User already is in team');
        }

        DB::transaction(function () use ($user, $invite, $team) {
            $team->members()->attach($user);
            $user->update(['current_team_id' => $team->id]);
            $invite->delete();
        });

        return redirect()->route('teams.show');
    }

    public function resend(Request $request, Invite $invite)
    {
        $authName = $request->user()->name;
        $team = $request->user()->team;

        $user = (new User())->fill(['email' => $invite->email]);

        $user->notify(new TeamMemberInvited(
            name: $authName,
            teamName: $team->name,
            token: $invite->token
        ));

        return redirect()->back();
    }

    public function destroy(Invite $invite)
    {
        $invite->delete();

        return redirect()->route('teams.show');
    }
}
