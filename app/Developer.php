<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
protected $table = 'developers';
protected $fillable = [
   'name',
  'logo',
  'website' ,
  'email',
  'sponsor',
    ];
}
