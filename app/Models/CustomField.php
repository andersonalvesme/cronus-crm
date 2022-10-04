<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use LastInsertId;

    protected $table = 'vw_custom_fields';

    protected $fillable = [
        'name', 'fields'
    ];

    public function getFieldsAttribute($value)
    {
        return json_decode($value, true);
    }
}
