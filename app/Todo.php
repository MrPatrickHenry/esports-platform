<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
  protected $table = 'tasks';
  protected $fillable = [

    'title',
    'status',
    'priority',
    'category',
    'user_ID',
    'tournament_ID',
    'description'

  ];

}
