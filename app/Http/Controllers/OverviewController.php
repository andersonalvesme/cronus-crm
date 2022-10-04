<?php

namespace App\Http\Controllers;

use App\Models\UserMetric;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $p = UserMetric::where('user_id', auth()->id())->get();

        $metrics = $p->map(function ($item) use ($user) {
            $resource = $item->resource;
            if (in_array("{$resource}.index", $user->permissions())) {
                $model = $item->model::getModel();
                $values = $model::metrics(
                    json_decode($item->params, true),
                    $item->metric_type,
                    $item->group_by,
                    $item->time_peroid
                );

                if (!is_int($values)) {
                    $values_aux = $values;
                    $values = [];
                    foreach ($values_aux as $value) {
                        $values[] = $value['value'];
                    }
                }

                return [
                    'card_label' => $item->card_label,
                    'values' => $values,
                    'id' => $item->id,
                    'type' => $item->metric_type,
                    'chart_type' => $item->chart_type,
                    'color' => $item->color,
                    'i' => $item->id,
                    'x' => $item->grid_position_x,
                    'y' => $item->grid_position_y,
                    'w' => $item->grid_width,
                    'h' => $item->grid_height,
                ];
            }
            return [
                'card_label' => $item->card_label . ' - ' . __('lang.un_auth'),
                'value' => 0,
                'id' => $item->id,
                'type' => $item->metric_type
            ];
        });

        return to_json([
            'metrics' => $metrics
        ]);
    }

    public function save(Request $request)
    {
        $metrics = $request->all();

        foreach ($metrics as $metric) {
            UserMetric::where(['user_id' => auth()->id(), 'id' => $metric['id']])
                ->update([
                    'grid_position_x' => $metric['x'],
                    'grid_position_y' => $metric['y'],
                    'grid_width' => $metric['w'],
                    'grid_height' => $metric['h'],
                ]);
        }

        return to_json([
            'saved' => true
        ]);
    }
}
