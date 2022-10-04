<?php

namespace App\Emails;

use App\Jobs\SendMail;
use App\Models\Template\Template;
use Illuminate\Database\Eloquent\Model;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SendDocument
{
    protected $model;
    protected $info;
    protected $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, $info, $type)
    {
        $this->model = $model;
        $this->info = $info;
        $this->type = $type;

        $this->send();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function send()
    {
        $html = settings()->get('email_base_html');
        $css = settings()->get('email_stylesheet');

        if ($this->type == 'payment') {
            $template = Template::with('pages')
                ->findOrFail(settings()->get('default_payment_template_id'));
            $this->model->applied_invoices_table = render_applied_invoices_table($this->model);
        } else {
            $template = Template::with('pages')
                ->findOrFail($this->model->template_id);
        }

        $file = app('App\Services\TemplateParser')->documentPreview($template, $this->model)
            ->toString();
        $file = utf8_encode($file);

        $filename = __('lang.' . $this->type) . '-' . $this->model->number . '.pdf';

        $bcc = [];

        if ($this->info['bcc']) {
            $bcc[] = $this->info['bcc'];
        }

        if ($gbcc = settings()->get('global_bcc')) {
            $bcc[] = $gbcc;
        }

        SendMail::dispatch(
            [
                'email_from_address' => settings()->get('email_from_address'),
                'email_from_name' => settings()->get('email_from_name'),
                'subject' => $this->info['subject'],
                'to' => $this->info['email_to'],
                'bcc' => $bcc,
                'html' => (new CssToInlineStyles)->convert(parseEmailHTML($html, $this->info['message']), $css),
                'file' => $file,
                'filename' => $filename,
                'mime' => 'application/pdf'
            ]
        );
    }
}
