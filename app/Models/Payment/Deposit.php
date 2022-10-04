<?php

namespace App\Models\Payment;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_payment_deposits';

    protected $fillable = ['name'];

    protected $sortable = [
        'id', 'name', 'created_at'
    ];

    protected $searchable = ['name'];

    protected $allowedFilters = [];
}
