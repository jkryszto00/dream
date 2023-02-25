<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Models\Team\Team;
use Illuminate\Http\Request;

class SelectTeamController extends Controller
{
    public function select(Request $request)
    {
        $auth = $request->user();
        $teams = $auth->getRelationValue('teams');

        return inertia('Team/Select', [
            'teams' => $teams
        ]);
    }

    public function selected(Team $team, Request $request)
    {
        $auth = $request->user();
        $auth->update(['current_team_id' => $team->getKey()]);

        return redirect()->route('teams.show');
    }
}
