<?php

namespace App\Http\Controllers;

use App\Models\Expense\Category;
use DB;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function search()
    {
        return to_json([
            'collection' => Category::search()
        ]);
    }

    public function index()
    {
        $this->authorize('access', 'settings.expenses');
        return to_json([
            'collection' => Category::filter()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', 'settings.expenses');
        $request->validate([
            'name' => 'required|unique:expense_categories,name,NULL,NULL,tenant_id,' . auth()->user()->id,
        ]);

        $item = new Category;
        $item->name = $request->name;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function update($id, Request $request)
    {
        $this->authorize('access', 'settings.expenses');
        $request->validate([
            'name' => 'required|unique:expense_categories,name,' . $id . ',id,tenant_id,' . auth()->user()->id,
        ]);

        $item = Category::findOrFail($id);
        $item->name = $request->name;
        $item->save();

        return to_json([
            'saved' => true,
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('access', 'settings.expenses');
        $model = Category::findOrFail($id);

        if (DB::table('expenses')->where('category_id', $model->id)->count()) {
            return delete_first(__('lang.cannot_delete'));
        }

        // check settings
        if (settings()->check('default_expense_category_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
