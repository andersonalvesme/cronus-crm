<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use LastInsertId;

	protected $table = 'vw_counters';
	protected $appends = ['number'];

	public function getNumberAttribute()
	{
	    return $this->attributes['prefix'].$this->attributes['value'];
	}
}
