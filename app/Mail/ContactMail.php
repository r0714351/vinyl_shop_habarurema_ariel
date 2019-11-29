<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /** Create a new message instance. ...*/
    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request->fromEmail, 'The Vinyl Shop - '. $this->request->nameMail)
            ->cc($this->request->fromEmail, 'The Vinyl Shop - ' . $this->request->nameMail)
            ->subject('The Vinyl Shop - Contact Form')
            ->markdown('email.contact');
    }
}
