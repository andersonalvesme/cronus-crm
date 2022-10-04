<?php

namespace App\Models\Payment;

use App\Models\Invoice\Invoice;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use LastInsertId;

    protected $table = 'vw_payment_lines';

    protected $fillable = [
        'invoice_id', 'amount_applied'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
