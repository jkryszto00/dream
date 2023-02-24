<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
