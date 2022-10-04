<?php

namespace App\Models\Expense;

use App\Models\Opportunity\Opportunity;
use App\Models\Project\Project;
use App\Models\Vendor\Vendor;
use App\Support\Filterable;
use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use LastInsertId, Filterable;

    protected $table = 'vw_expenses';

    protected $fillable = [
        'vendor_id', 'category_id', 'date', 'amount', 'description',
        'project_id', 'opportunity_id'
    ];

    protected $sortable = ['id', 'created_at', 'date', 'number', 'amount'];

    protected $searchable = ['number'];

    protected $allowedFilters = [
        'id', 'number', 'date', 'description', 'amount', 'created_at',
        'vendor.id', 'vendor.number', 'vendor.name', 'vendor.created_at',
        'category.name', 'project.number', 'project.created_at',
        'opportunity.number', 'opportunity.created_at',
    ];

    protected $hidden = ['custom_values'];

    public static function templateVariables($key, $show = true)
    {
        $base = [
            'id', 'number', 'category.name', 'date', 'description', 'amount',
        ];

        $b = collect($base)->map(function ($item) use ($key) {
            if (is_null($key)) {
                return $item;
            }
            return $key . '.' . $item;
        });

        if ($show) {

            $cf = custom_fields_names('expenses');
            $c = collect($cf)->map(function ($item) use ($key) {
                if (is_null($key)) {
                    return $item;
                }
                return $key . '.' . $item;
            });

            $f = $b->merge($c);
            return $f->toArray();
        }


        return $b->toArray();
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class, 'opportunity_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function exportable()
    {
        return [
            'id', 'number', 'category.name', 'date', 'description', 'amount', 'created_at',
            'vendor.id', 'vendor.number', 'vendor.name', 'vendor.created_at',
            'project.number', 'project.created_at',
            'opportunity.number', 'opportunity.created_at'
        ];
    }
}
