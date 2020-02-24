<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Billable, Notifiable, HasApiTokens ;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'userType',
		'gamertag',
		'profilePic',
		'authToken',
		'activated_at',
		'uuid',
		'phone',
		'gender',
		'headset',
		'address1',
		'address2',
		'city',
		'state',
		'country',
		'zip_postal',
		'youtube',
		'snapchat',
		'twitter',
		'coverboard',
    'facebook',
		'telegram',
		'instagram',
		'discord',
		'dob',
		'home_arcade',
		'team',
		'favourite_VR_Title',
		'public',
		'twitch'

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token','email_verified_at','activated_at'
	];

	protected $guarded = [
		'userType'
	];
	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
}
