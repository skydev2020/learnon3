<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd(gettype($this->data['message']));
        return $this->subject($this->data['subject'])->view('admin.emailsend.mail')
                ->with([
                    'name'              => "Learnon Tutoring!",
                    "email"             => "info@learnon.ca" ,
                    'subject'           => $this->data['subject'],
                    'user_message'      => $this->data['message'],
                ]);
    }
}
