<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class PhoneCall extends Model
{
    use LastInsertId;

    protected $table = 'vw_phone_calls';
}
