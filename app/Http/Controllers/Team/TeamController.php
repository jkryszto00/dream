<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamStoreRequest;
use App\Models\Team\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function show(Request $request)
    {
        $team = $request->user()->currentTeam();

        $members = $team->members;
        $invites = $team->invites;

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
        $user = $request->user();

        DB::transaction(function () use ($user, $request) {
            $team = Team::create([
                ...$request->validated(),
                'user_id' => $user->getKey()
            ]);

            $team->members()->attach($user);

            $user->update([
                'current_team_id' => $team->id
            ]);
        });

        return redirect()->route('dashboard');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
