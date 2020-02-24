<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'featureService';
    protected $fillable = [
    	'icon',
    	'english_Label',
    	'uri',
    	'user_IDs',
    	'country',
    	'player_Type',
    	'user_Type'
    ];
}
