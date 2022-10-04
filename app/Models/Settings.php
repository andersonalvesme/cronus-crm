<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use LastInsertId;

    protected $table = 'vw_settings';

    protected $fillable = ['key', 'value'];
}
