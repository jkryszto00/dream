<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $team = $request->user()->currentTeam();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'isOwner' => $team->isOwner($this->id),
        ];
    }
}
