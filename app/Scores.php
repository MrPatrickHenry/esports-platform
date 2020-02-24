<?php

namespace App;
use App\Files;
use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{

    protected $table = 'Scores';
protected $fillable = [
        'tournament',
        'round',
        'homeArcade',
        'homePlayer',
        'opponenet',
        'Match1',
        'Match2',
        'Match3',
        'Match1Score',
        'Match2Score',
        'Match3Score',
        'comments',
        'winner',
        'referee',
        'confirmed',
        'created_at',
        'updated_at',
        'dispute',
        'submitedBy'
    ];


    public function files()
    {
        return $this->hasMany('Files');
    }
}
