<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
protected $table = 'messages';
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
