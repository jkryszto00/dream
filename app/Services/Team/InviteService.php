<?php

namespace App\Services\Team;

use App\Exceptions\Team\UserIsInTeamException;
use App\Models\Team\Invite;
use App\Models\Team\Team;
use App\Models\User;
use App\Notifications\TeamMemberInvited;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InviteService
{
    public function store(string $email, string $name, Team $team): Invite
    {
        $invite = Invite::create([
            'team_id' => $team->getKey(),
            'email' => $email,
            'token' => Str::random(32)
        ]);

        $user = (new User())->fill(['email' => $email]);
        $user->notify(new TeamMemberInvited(
            name: $name,
            teamName: $team->getAttribute('name'),
            token: $invite->getAttribute('token')
        ));

        return $invite;
    }

    public function accept(User $user, Invite $invite): void
    {
        $team = $invite->getRelationValue('team');

        if ($user->inTeam($team->getKey())) {
            $this->delete($invite);
            throw new UserIsInTeamException();
        }

        $memberService = new MemberService();

        $memberService->attachUser(
            user: $user,
            team: $team
        );

        $this->delete($invite);
    }

    public function acceptAsGuest(Invite $invite, ?string $email = null): void
    {
        if (!$email) {
            $email = $invite->getAttribute('email');
        }

        $user = User::whereEmail($email)->first();

        DB::transaction(function () use ($user, $email, $invite) {
            if (!$user) {
                $user = (new UserService())->createUserWithEmail($email);
            }

            $this->accept($user, $invite);
        });
    }

    public function resend(Invite $invite, string $name, Team $team): void
    {
        $user = (new User())->fill(['email' => $invite->getAttribute('email')]);

        $user->notify(new TeamMemberInvited(
            name: $name,
            teamName: $team->getAttribute('name'),
            token: $invite->getAttribute('token')
        ));

        $invite->touch();
    }

    public function delete(Invite $invite): void
    {
        $invite->delete();
    }
}
