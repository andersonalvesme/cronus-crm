<?php

namespace App\Http\Controllers;

use App\Models\Contact\Contact;
use App\Models\Contract\Contract;
use App\Models\Expense\Expense;
use App\Models\Invoice\Invoice;
use App\Models\Item\Item;
use App\Models\Lead\Lead;
use App\Models\Opportunity\Opportunity;
use App\Models\Organization\Organization;
use App\Models\Payment\Payment;
use App\Models\Payment\Request as PaymentRequest;
use App\Models\Project\Project;
use App\Models\Proposal\Proposal;
use App\Models\UserMetric;
use Illuminate\Http\Request;

class UserMetricController extends Controller
{
    protected $types = [
        'contacts', 'organizations', 'items', 'leads',
        'opportunities', 'proposals', 'contracts',
        'projects', 'invoices', 'payments',
        'expenses', 'vendors', 'payment_requests'
    ];

    public function store(Request $request)
    {

        $data = $request->validate([
            'card_label' => 'required|string',
            // 'sort_column' => 'sometimes|required',
            // 'sort_direction' => 'sometimes|required|in:asc,desc',
            'filter_match' => 'sometimes|required|in:and,or',
            'f' => 'sometimes|array',
            'resource' => 'required|in:' . implode(',', $this->types),
            'metric_type' => 'required|in:value,chart', // metric_type,
            'time_peroid' => 'required',
            'chart_type' => 'required',
            'group_by' => 'required',
            'color' => 'sometimes'
        ]);

        // $this->authorize('access', $request->resource.'.export');

        if ($request->has('f')) {
            $params = [
                // 'sort_column' => $request->sort_column,
                // 'sort_direction' => $request->sort_direction,
                'filter_match' => $request->filter_match,
                'f' => $request->f
            ];
        } else {
            $params = [
                // 'sort_column' => $request->sort_column,
                // 'sort_direction' => $request->sort_direction,
                'filter_match' => $request->filter_match,
            ];
        }

        $re = new UserMetric;
        $re->fill($data);
        $re->filter_match = $request->filter_match;
        $re->metric_type = $request->metric_type;
        $re->params = json_encode($params);
        $re->resource = $request->resource;
        switch ($request->resource) {
            case 'contacts':
                $re->model = Contact::class;
                break;
            case 'organizations':
                $re->model = Organization::class;
                break;
            case 'items':
                $re->model = Item::class;
                break;
            case 'leads':
                $re->model = Lead::class;
                break;
            case 'opportunities':
                $re->model = Opportunity::class;
                break;
            case 'proposals':
                $re->model = Proposal::class;
                break;
            case 'contracts':
                $re->model = Contract::class;
                break;
            case 'projects':
                $re->model = Project::class;
                break;
            case 'payments':
                $re->model = Payment::class;
                break;
            case 'payment_requests':
                $re->model = PaymentRequest::class;
                break;
            case 'expenses':
                $re->model = Expense::class;
                break;
            case 'expenses':
                $re->model = Expense::class;
                break;
            case 'invoices':
                $re->model = Invoice::class;
                break;
            // todo more
            default:
                abort(404, 'Not Found!');
                break;
        }

        // card position
        $metricsCount = UserMetric::where('user_id', auth()->id())->count();

        $re->grid_position_x = ($metricsCount * 2) % 12;
        $re->grid_position_y = $metricsCount + 1;
        $re->grid_width = 3;
        $re->grid_height = 3;

        auth()
            ->user()
            ->metrics()
            ->save($re);

        return to_json([
            'saved' => true
        ]);
    }

    public function destroy($id)
    {
        $found = UserMetric::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();


        $found->delete();

        return to_json([
            'deleted' => true
        ]);
    }
}
