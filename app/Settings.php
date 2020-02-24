<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'settings';
    protected $fillable = [
        'user_ID',
        'share3rdParties',
        'homeArcade',
        'searchable',
        'delete'
    ];


        protected $hidden = [
                'id','created_at'
        ];

}
