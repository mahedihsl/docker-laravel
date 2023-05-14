<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class setNewPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $email_content;

    public function __construct($email_content)

    {
        //
        $this->email_content = $email_content;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      //print_r($this->email_content);die;
      return $this->markdown('emails.setNewPassword')
                     ->subject('Reset Password')   
                     ->with([
                        'text' => $this->email_content['text'],
                        'link' => $this->email_content['link'],
                    ]);
    }
}
