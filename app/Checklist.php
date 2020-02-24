<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
  protected $table = 'checkLists';
  protected $fillable = [
    'todo',
    'is_completed',
    'task_id'
  ];

}
