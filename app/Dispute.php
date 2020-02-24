<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    

       protected $table = 'disputes';
protected $fillable = [
        'scoreID',
        'comment',
        'evidance',
        'submitedBy',
        'decision',
        'reviewedBy'
        'created_at',
        'updated_at'
    ];
}
