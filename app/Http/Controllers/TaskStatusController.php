<?php

namespace App\Http\Controllers;

use App\Models\Task\Status;
use DB;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function index()
    {
        $this->authorize('access', 'settings.tasks');
        return to_json([
            'collection' => Status::filter()
        ]);
    }

    public function search()
    {
        return to_json([
            'collection' => Status::search()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', 'settings.tasks');
        $request->validate([
            'name' => 'required|unique:task_statuses,name,NULL,NULL,tenant_id,' . auth()->user()->id,
            'color' => 'required|alpha_dash|unique:task_statuses,color,NULL,NULL,tenant_id,' . auth()->user()->id,
            'locked' => 'required|boolean'
        ]);

        $item = new Status;
        $item->name = $request->name;
        $item->color = $request->color;
        $item->locked = $request->locked;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function update($id, Request $request)
    {
        $this->authorize('access', 'settings.tasks');
        $request->validate([
            'name' => 'required|unique:task_statuses,name,' . $id . ',id,tenant_id,' . auth()->user()->id,
            'color' => 'required|alpha_dash|unique:task_statuses,color,' . $id . ',id,tenant_id,' . auth()->user()->id,
            'locked' => 'required|boolean'
        ]);

        $item = Status::findOrFail($id);
        $item->name = $request->name;
        $item->color = $request->color;
        $item->locked = $request->locked;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('access', 'settings.tasks');
        $model = Status::findOrFail($id);

        if (DB::table('tasks')->where('status_id', $model->id)->count()) {
            return delete_first(__('lang.cannot_delete'));
        }

        // check settings
        if (settings()->check('task_status_on_create_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
