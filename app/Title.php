<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
	protected $table = 'titles';
	protected $fillable = [
		'name',
		'developer',
		'desc',
		'availability',
		'rules',
		'links',
		'pic',
		'video',
		'icon',
		'active',
		'player_Count',
		'header_Image',
		'game_Type'
	];


		protected $hidden = [
				'id','created_at'
		];

}
