<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
	 protected $table = 'tracking';
		protected $fillable = [
		'files_id',
		'user_id',
		'impression',
		'click',
		'userDevice',
		'ipaddress'
		];
}
