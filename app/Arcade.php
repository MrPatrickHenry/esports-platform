<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arcade extends Model
{
protected $table = 'arcades';
protected $fillable = [
		'adminID',
		'arcadeName',
		'description',
		'email',
		'website',
		'youtubeVideo',
		'youtubeChannel',
		'discord',
		'instagram',
		'telegram',
		'twitter',
		'snapchat',
		'twitch',
		'address1',
		'address2',
		'city',
		'state',
		'Country',
		'zip_postal',
		'lat',
		'lng',
		'phone',
		'notes',
		'logo',
		'header_Image',
		'pic2',
		'pic3',
		'pic4',
		'icon',
		'active',
		'tier',
		'licensing',
		'hours',
		'verified'
	];
}
