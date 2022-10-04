<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use LastInsertId;

    protected $table = 'vw_notes';

    protected $hidden = [
    	'notable_id', 'notable_type'
    ];

    public function notable()
    {
        return $this->morphTo();
    }
}
