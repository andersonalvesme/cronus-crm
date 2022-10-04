<?php

namespace App\Models;

use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class RecurringExport extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_recurring_exports';

    protected $fillable = [
        'email_to', 'frequency', 'send_on', 'send_at', 'name'
    ];

    protected $sortable = [
        'id', 'created_at'
    ];

    protected $searchable = [
    ];

    protected $allowedFilters = [
        'id', 'email_to', 'frequency', 'send_on', 'send_at', 'name', 'created_at'
    ];
}
