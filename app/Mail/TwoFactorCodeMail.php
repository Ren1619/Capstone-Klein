<?php

namespace App\Mail;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $account;
    public $code;

    /**
     * Create a new message instance.
     *
     * @param  Account  $account
     * @param  string  $code
     * @return void
     */
    public function __construct(Account $account, $code)
    {
        $this->account = $account;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Verification Code')
            ->view('auth.mail.verification-code-mail-template') // Updated to use your file path
            ->with([
                'code' => $this->code,
                'account' => $this->account
            ]);
    }
}