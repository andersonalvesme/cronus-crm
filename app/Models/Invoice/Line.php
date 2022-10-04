<?php

namespace App\Models\Invoice;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use LastInsertId;

    protected $table = 'vw_invoice_lines';
}
