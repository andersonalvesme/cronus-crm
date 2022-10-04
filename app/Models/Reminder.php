<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use LastInsertId;

    protected $table = 'vw_reminders';
}
