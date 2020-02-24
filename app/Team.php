<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teamProfile';
protected $fillable = [
        'team_Logo',
        'website',
        'instagram',
        'twitter',
        'twitter',
        'discord',
        'team_Name',
        'team_Manager',
        'home_arcade',
        'recruting'
    ];
}
