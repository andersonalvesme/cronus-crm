<?php

namespace App\Http\Controllers;

use App\Models\Opportunity\Source;
use DB;
use Illuminate\Http\Request;

class OpportunitySourceController extends Controller
{
    public function typeahead()
    {
        $results = Source::typeahead(['name']);

        return to_json([
            'results' => $results
        ]);
    }

    public function search()
    {
        return to_json([
            'collection' => Source::search()
        ]);
    }

    public function index()
    {
        $this->authorize('access', 'settings.opportunities');
        return to_json([
            'collection' => Source::filter()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', 'settings.opportunities');
        $request->validate([
            'name' => 'required|unique:opportunity_sources,name,NULL,NULL,tenant_id,' . auth()->user()->id,
        ]);

        $item = new Source;
        $item->name = $request->name;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function update($id, Request $request)
    {
        $this->authorize('access', 'settings.opportunities');
        $request->validate([
            'name' => 'required|unique:opportunity_sources,name,' . $id . ',id,tenant_id,' . auth()->user()->id,
        ]);

        $item = Source::findOrFail($id);
        $item->name = $request->name;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('access', 'settings.opportunities');
        $model = Source::findOrFail($id);

        if (DB::table('opportunities')->where('source_id', $model->id)->count()) {
            return delete_first(__('lang.cannot_delete'));
        }

        // check settings
        if (settings()->check('default_opportunity_source_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
