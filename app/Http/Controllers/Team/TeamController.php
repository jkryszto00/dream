<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamStoreRequest;
use App\Services\Team\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(
        readonly private TeamService $teamService
    ){}

    public function show(Request $request)
    {
        $team = $request->user()->currentTeam();

        $members = $team->getRelationValue('members');
        $invites = $team->getRelationValue('invites');

        return inertia('Team/Show', [
            'members' => $members,
            'invites' => $invites
        ]);
    }

    public function create()
    {
        return inertia('Team/Create');
    }

    public function store(TeamStoreRequest $request)
    {
        $owner = $request->user();

        $this->teamService->store(
            name: $request->validated('name'),
            owner: $owner
        );

        return redirect()->route('dashboard');
    }
}
