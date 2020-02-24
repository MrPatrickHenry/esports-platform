<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament_Types extends Model
{
    protected $table = 'tournaments_types';
protected $fillable = [
        'type'
    ];

}
