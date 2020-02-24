<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
     protected $table = 'tournaments';
protected $fillable = [

  'name',
  'gameID',
  'sponsorUserID',
  'sponsorName',
  'launchStartDate',
  'launchEndDate',
  'startDate',
  'endDate',
  'descriptionTournament',
  'rules',
  'rewards',
  'email',
  'iconID',
  'bannerID',
  'pic1',
  'pic2',
  'video',
  'twitter',
  'discord',
  'twitch',
  'youtube',
  'notes',
  'active',
  'likes',
  'eventType',
  'room',
  'password',
  'key',
  'mediaKit',
  'short-Tag',
  'summary',
  'group'
    ];

}
