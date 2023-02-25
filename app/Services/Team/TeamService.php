<?php

namespace App\Services\Team;

use App\Models\Team\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function __construct(
        readonly private MemberService $memberService
    ){}

    public function store(string $name, User $owner): Team
    {
        return DB::transaction(function () use ($name, $owner) {
            $team = Team::create([
                'user_id' => $owner->getKey(),
                'name' => $name
            ]);

            $this->memberService->attachUser(
                user: $owner,
                team: $team
            );

            return $team;
        });
    }
}
