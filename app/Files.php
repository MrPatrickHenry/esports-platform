<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
	use SoftDeletes;

        protected $dates = ['deleted_at'];  
	protected $table = 'files';
	protected $fillable = [
		'user_id',
		'file_name',
		'type',
		'homePlayer',
		'path',
		'is_public',
		'description',
		'category_id'
	];

public function scopeThat($query)
{
	return $query->where('user_id','=', $query, 'is_public', '=', 1, 'deleted_at', '=', null);
}
}
