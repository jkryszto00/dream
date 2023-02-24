<?php

namespace App\Models;

use App\Models\Team\Team;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function inTeam(int $id)
    {
        return $this->teams()->where('id', $id)->exists();
    }

    public function haveTeam()
    {
        return $this->teams()->count() > 0;
    }

    public function currentTeam()
    {
        return $this->teams()->where('id', $this->current_team_id)->first();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
