<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentLocker extends Model
{
  protected $table = 'contentLocker';
  protected $fillable = [
    'video',
    'thumbnail',
    'title',
    'description',
    'tags',
    'game',
    'like',
    'dislike'
  ];
}
