<?php

namespace App\Models\Payment;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use LastInsertId;

    protected $table = 'vw_payment_tokens';

    protected $fillable = [
        'request_id', 'value', 'type', 'gateway', 'other', 'email'
    ];
}
