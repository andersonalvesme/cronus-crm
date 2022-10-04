<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment\Method;
use DB;

class PaymentMethodController extends Controller
{
    public function search()
	{
	    return to_json([
	        'collection' => Method::search()
	    ]);
	}

	public function index()
	{
		$this->authorize('access', 'settings.payments');
	    return to_json([
	        'collection' => Method::filter()
	    ]);
	}

	public function store(Request $request)
	{
		$this->authorize('access', 'settings.payments');
	    $request->validate([
	        'name' => 'required|unique:payment_methods,name,NULL,NULL,tenant_id,' . auth()->user()->id,
	    ]);

	    $item = new Method;
	    $item->name = $request->name;
	    $item->save();

	    return to_json([
	        'saved' => true,
	        'item' => $item
	    ]);
	}

	public function update($id, Request $request)
	{
		$this->authorize('access', 'settings.payments');
	    $request->validate([
	        'name' => 'required|unique:payment_methods,name,'.$id.',id,tenant_id,' . auth()->user()->id,
	    ]);

	    $item = Method::findOrFail($id);
	    $item->name = $request->name;
	    $item->save();

	    return to_json([
	        'saved' => true,
	        'item' => $item
	    ]);
	}

	public function destroy($id)
    {
    	$this->authorize('access', 'settings.payments');
        $model = Method::findOrFail($id);

        if(DB::table('payments')->where('method_id', $model->id)->count()) {
            return delete_first(__('lang.cannot_delete'));
        }

        // check settings
        if(settings()->check('default_payment_method_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        // stripe, paypal, razor
        if(settings()->check('stripe_payment_method_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        if(settings()->check('razorpay_payment_method_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        if(settings()->check('paypal_payment_method_id', $model->id)) {
            return delete_first(__('lang.cannot_delete'));
        }

        $model->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
