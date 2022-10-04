<?php

namespace App\Models\Activity;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use LastInsertId;

    protected $table = 'vw_activities';

    protected $fillable = [
        'callable_id', 'callable_type', 'type_id', 'description', 'date'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
