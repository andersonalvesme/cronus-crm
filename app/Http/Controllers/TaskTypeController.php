<?php

namespace App\Http\Controllers;

use App\Models\Task\Type;
use DB;
use Illuminate\Http\Request;

class TaskTypeController extends Controller
{
    public function search()
    {
        return to_json([
            'collection' => Type::search()
        ]);
    }

    public function index()
    {
        $this->authorize('access', 'settings.tasks');
        return to_json([
            'collection' => Type::filter()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', 'settings.tasks');
        $request->validate([
            'name' => 'required|unique:task_types,name,NULL,NULL,tenant_id,' . auth()->user()->id,
        ]);

        $item = new Type;
        $item->name = $request->name;
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
            'name' => 'required|unique:task_types,name,' . $id . ',id,tenant_id,' . auth()->user()->id,
        ]);

        $item = Type::findOrFail($id);
        $item->name = $request->name;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('access', 'settings.tasks');
        $model = Type::findOrFail($id);

        if (DB::table('tasks')->where('type_id', $model->id)->count()) {
            return delete_first(__('lang.cannot_delete'));
        }

        if (settings()->check('default_task_type_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
