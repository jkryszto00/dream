<?php

namespace App\Http\Controllers\Team;

use App\Exceptions\Team\UserIsInTeamException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContinueWithEmailRequest;
use App\Http\Requests\Team\InviteStoreRequest;
use App\Models\Team\Invite;
use App\Models\User;
use App\Services\Team\InviteService;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function __construct(
        readonly private InviteService $inviteService
    ) {}

    public function store(InviteStoreRequest $request)
    {
        $auth = $request->user();

        $this->inviteService->store(
            email: $request->validated('email'),
            name: $auth->getAttribute('name'),
            team: $auth->currentTeam()
        );

        return redirect()->back();
    }

    public function accept(Request $request, string $token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        $user = $request->user();

        try {
            if (!$user) {
                return inertia('Invite/ContinueWithEmail', [
                    'token' => $token
                ]);
            }

            $this->inviteService->accept(
                user: $user,
                invite: $invite
            );
        } catch (UserIsInTeamException) {
            return redirect()->route('teams.show');
        }

        return redirect()->route('teams.show');
    }

    public function continueWithEmail(string $token, ContinueWithEmailRequest $request)
    {
        $email = $request->validated('email');
        $user = User::query()->whereEmail($email)->first();
        $invite = Invite::query()->whereToken($token)->firstOrFail();

        if ($user) {
            $this->inviteService->accept(
                user: $user,
                invite: $invite
            );
        } else {
          $this->inviteService->acceptAsGuest(
              invite: $invite,
              email: $email
          );
        }

        return redirect()->route('login');
    }

    public function resend(Request $request, Invite $invite)
    {
        $auth = $request->user();

        $this->inviteService->resend(
            invite: $invite,
            name: $auth->getAttribute('name'),
            team: $auth->currentTeam()
        );

        return redirect()->back();
    }

    public function destroy(Invite $invite)
    {
        $this->inviteService->delete(
            invite: $invite
        );

        return redirect()->route('teams.show');
    }
}
