<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RosterInvite extends Model
{
    protected $table = 'RosterInvite';
protected $fillable = [
        'users_Email',
        'status',
        'team_ID',
        'player_ID'
            ];
}
