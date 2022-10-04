<?php

namespace App\Http\Controllers;

use App\Models\Task\Status;
use App\Models\Task\Task;
use App\Models\Task\Type;
use App\Services\ExportCSV;
use DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function typeahead()
    {
        $results = Task::typeahead(['number']);

        return to_json([
            'results' => $results
        ]);
    }

    public function search()
    {
        return to_json([
            'collection' => Task::search()
        ]);
    }

    public function export()
    {
        $this->authorize('access', 'tasks.export');
        return (new ExportCSV(Task::with('status', 'type'), 'tasks'))
            ->download();
    }

    public function index()
    {
        $this->authorize('access', 'tasks.index');
        return to_json([
            'collection' => Task::with([
                'status:id,name,color'
            ])->filter()
        ]);
    }

    public function create()
    {
        $this->authorize('access', 'tasks.create');
        $form = [
            'number' => __('lang.auto_generated'),
            'subject' => null,
            'description' => null,
            'user_id' => null,
            'type_id' => null,
            'type' => null,
            'due_date' => null,
            'time' => null,
            'priority' => null,
        ];

        $id = settings()->get('default_task_type_id');

        if ($id) {
            $c = Type::findOrFail($id);

            $form['type'] = [
                'name' => $c->name,
                'id' => $c->id
            ];

            $form['type_id'] = $id;
        }

        return to_json([
            'form' => $form
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', 'tasks.create');
        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'type_id' => 'required|exists:task_types,id',
            'due_date' => 'nullable|date_format:Y-m-d',
        ]);

        $d = new Task();
        $request['user_id'] = auth()->user()->id;
        $d->fill($request->all());

        $id = settings()->get('task_status_on_create_id');

        if ($id) {
            $c = Status::findOrFail($id);
            $d->status_id = $c->id;
        } else {
            $d->status_id = Status::first()->id;
        }

        $d = DB::transaction(function () use ($d) {
            $c = counter('task');
            $d->number = $c->number;
            $d->save();
            $c->increment('value');

            return $d;
        });

        return response()
            ->json([
                'saved' => true,
                'id' => $d->id
            ]);
    }

    public function show($id)
    {
        $this->authorize('access', 'tasks.show');
        $pp = Task::with([
            'status:id,name,color',
            'type:id,name'
        ])->findOrFail($id);


        $pp->all_statuses = Status::where('locked', 0)->get();

        return to_json([
            'model' => $pp
        ]);
    }

    public function edit($id)
    {
        $this->authorize('access', 'tasks.update');
        $pp = Task::with([
            'status:id,name,color',
            'type:id,name'
        ])->findOrFail($id);

        return to_json([
            'form' => $pp
        ]);
    }

    public function update($id, Request $request)
    {
        $this->authorize('access', 'tasks.update');
        $request->validate([
            'subject' => 'required',
            'type_id' => 'required|exists:task_types,id',
            'due_date' => 'nullable|date_format:Y-m-d',
        ]);

        $d = Task::findOrFail($id);
        $d->fill($request->all());
        $d->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $d->id
            ]);
    }

    public function markAs($id, Request $request)
    {
        $this->authorize('access', 'tasks.change_status');
        $request->validate([
            'type' => 'required|integer|exists:task_statuses,id,locked,0'
        ]);

        $task = Task::findOrFail($id);
        $task->status_id = $request->type;
        $task->save();

        return to_json([
            'saved' => true,
            'id' => $task->id,
            'status' => $task->status
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('access', 'tasks.delete');
        $model = Task::findOrFail($id);

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
