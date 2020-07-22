<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRecoveryMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $name,$password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@ssisgh.com', 'Apomuden')
                       ->subject('Account Recovery')
                       ->view('mails.user_recovery')
                      ->with('name', $this->name)
                      ->with('password', $this->password);
    }
}
