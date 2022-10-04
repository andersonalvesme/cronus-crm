<?php

namespace App\Models;

use App\Support\LastInsertId;
use Illuminate\Database\Eloquent\Model;

class UserMetric extends Model
{
    use LastInsertId;

    protected $table = 'vw_user_metrics';

    protected $fillable = [
        'card_label',
        'filter_match',
        'resource',
        'params',
        'model',
        'metric_type',
        'group_by',
        'chart_type',
        'time_peroid',
        'color',
        'grid_position_x',
        'grid_position_y',
        'grid_width',
        'grid_height'
    ];
}
