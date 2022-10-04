<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * email_from_address
     * email_from_name
     * to
     * bcc
     * to_name
     * subject
     * html
     * attachData
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        if (!$this->data['email_from_address']) {
            $this->data['email_from_address'] = 'contato@cronus.com';
            $this->data['email_from_name'] = 'Cronus CRM';
        }

        $mailer->send('emails.html', $this->data, function ($message) {
            $message->from($this->data['email_from_address'], $this->data['email_from_name']);
            $message->to($this->data['to']);
            $message->bcc($this->data['bcc']);
            $message->subject($this->data['subject']);

            if ($this->data['file']) {
                $message->attachData(utf8_decode($this->data['file']), $this->data['filename'], ['mime' => $this->data['mime']]);
            }
        });
    }
}
