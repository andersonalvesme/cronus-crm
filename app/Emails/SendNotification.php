<?php

namespace App\Emails;

use App\Jobs\SendMail;
use Illuminate\Database\Eloquent\Model;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SendNotification
{
    public $info;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, $info)
    {
        $this->model = $model;
        $this->info = $info;

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

        SendMail::dispatch(
            [
                'email_from_address' => settings()->get('email_from_address'),
                'email_from_name' => settings()->get('email_from_name'),
                'subject' => $this->info['subject'],
                'to' => $this->info['email_to'],
                'bcc' => [],
                'html' => (new CssToInlineStyles)->convert(parseEmailHTML($html, $this->info['message']), $css)
            ]
        );
    }
}
