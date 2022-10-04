<?php

namespace App\Http\Controllers;

use App\Models\Task\Status;
use App\Models\Task\Type;
use Illuminate\Http\Request;

class TaskSettingsController extends Controller
{
    public function show()
    {
        $this->authorize('access', 'settings.tasks');

        $form = [
            'task_status_on_create_id' => null,
            'task_status_on_create' => null,
            'default_task_type_id' => null,
            'default_task_type' => null,
        ];

        $id = settings()->get('task_status_on_create_id');

        if ($id) {
            $c = Status::findOrFail($id);
            $form['task_status_on_create'] = [
                'name' => $c->name,
                'id' => $c->id
            ];

            $form['task_status_on_create_id'] = $id;
        }

        $id = settings()->get('default_task_type_id');

        if ($id) {
            $c = Type::findOrFail($id);
            $form['default_task_type'] = [
                'name' => $c->name,
                'id' => $c->id
            ];

            $form['default_task_type_id'] = $id;
        }

        return to_json([
            'form' => $form
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('access', 'settings.tasks');
        $request->validate([
            'task_status_on_create_id' => 'required|integer',
            'default_task_type_id' => 'required|integer',
        ]);

        settings()->setMany(
            $request->only([
                'task_status_on_create_id',
                'default_task_type_id',
            ])
        );

        return to_json([
            'saved' => true
        ]);
    }

}
