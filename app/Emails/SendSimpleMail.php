<?php

namespace App\Emails;

use App\Jobs\SendMail;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SendSimpleMail
{
    public $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;

        $this->send();
    }

    /**
     * Build the message.
     *
     * @return $this
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
