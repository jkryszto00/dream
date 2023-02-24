<?php

namespace App\Http\Controllers\Team;

use App\Exceptions\Team\UserIsTeamOwnerException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Team\MemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(
        readonly MemberService $memberService
    ){}

    /**
     * @param Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\Team\UserIsTeamOwnerException
     */
    public function detachUser(Request $request, User $user): RedirectResponse
    {
        $team = $request->user()->currentTeam();
        $message = __('team.detach.success');

        try {
            $this->memberService->detachUser(
                user: $user,
                team: $team
            );
        } catch (UserIsTeamOwnerException) {
            $message = __('team.detach.error');
        }

        return redirect()->back()->with(['success' => $message]);
    }
}
