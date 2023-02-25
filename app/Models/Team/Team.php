<?php

namespace App\Models\Team;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function isOwner(int $userId)
    {
        return $this->user_id == $userId;
    }

    public function owner()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
