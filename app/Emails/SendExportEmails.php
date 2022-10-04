<?php

namespace App\Emails;

use App\Jobs\SendMail;
use App\Models\RecurringExport;
use App\Services\ExportCSV;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SendExportEmails
{
    public $export;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RecurringExport $export)
    {
        $this->export = $export;

        $this->send();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function send()
    {
        $model = $this->export->model::getModel();

        $file = (new ExportCSV(
            $model::with(json_decode($this->export->with, true)),
            $this->export->params,
            $this->getType($this->export->model)
        ))->toString();

        $filename = $this->export->name . '-' . now()->format(settings()->get('application_date_format')) . '.csv';

        // if(settings('email.global_bcc')) {
        //     $bcc[] = settings('email.global_bcc');
        // }

        $vars = [
            'name',
            'current_date'
        ];

        $d = [
            'name' => $this->export->name,
            'current_date' => now()
        ];

        $html = settings()->get('email_base_html');
        $css = settings()->get('email_stylesheet');

        $subject = parseSimpleTemplate(settings()
            ->get('recurring_export_email_subject'), $vars, $d);
        $message = parseSimpleTemplate(settings()
            ->get('recurring_export_email_template'), $vars, $d);

        SendMail::dispatch(
            [
                'email_from_address' => settings()->get('email_from_address'),
                'email_from_name' => settings()->get('email_from_name'),
                'subject' => $subject,
                'to' => $this->export->email_to,
                'bcc' => [],
                'html' => (new CssToInlineStyles)->convert(parseEmailHTML($html, $message), $css),
                'file' => $file,
                'filename' => $filename,
                'mime' => 'text/csv'
            ]
        );
    }

    protected function getType($model)
    {
        switch ($model) {
            case 'App\Models\Contact\Contact':
                return 'contacts';
                break;

            case 'App\Models\Organization\Organization':
                return 'organizations';
                break;

            case 'App\Models\Item\Item':
                return 'items';
                break;

            case 'App\Models\Lead\Lead':
                return 'leads';
                break;

            case 'App\Opportunities\Opportunities':
                return 'opportunities';
                break;

            case 'App\Models\Proposal\Proposal':
                return 'proposals';
                break;

            case 'App\Models\Contract\Contract':
                return 'contracts';
                break;

            case 'App\Models\Project\Project':
                return 'projects';
                break;

            case 'App\Models\Invoice\Invoice':
                return 'invoices';
                break;

            case 'App\Models\Payment\Payment':
                return 'payments';
                break;

            case 'App\Models\Expense\Expense':
                return 'expenses';
                break;

            case 'App\Models\Vendor\Vendor':
                return 'vendors';
                break;
            default:
                abort(404, 'export type not found');
                break;
        }
    }
}
