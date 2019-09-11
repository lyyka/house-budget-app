<?php

namespace App\Mail;

use App\HouseholdShare;
use Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HouseholdShared extends Mailable
{
    use Queueable, SerializesModels;

    public $owner;
    public $household;
    public $user_exists;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HouseholdShare $share_link)
    {
        $this->household = $share_link->household;
        $this->owner = $share_link->household->owner;
        $this->user_exists = count(\App\User::where('email', '=', $share_link->share_with_email)->where('id', '!=', Auth::id())->get()) == 1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.household.shared');
    }
}
