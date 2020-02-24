<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendees extends Model
{

protected $table = 'attendies';
protected $fillable = [
   'playerID',
  'teamsID',
  'tournamentID' ,
  'attended',
  'status'
    ];
}
