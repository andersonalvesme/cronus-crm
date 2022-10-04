<?php

namespace App\Models\Expense;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use LastInsertId;

    protected $table = 'vw_expense_vendors';
}
