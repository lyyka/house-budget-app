<?php

namespace App\Mail;
use App\HouseholdShare;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HouseholdShareRevoked extends Mailable
{
    use Queueable, SerializesModels;

    public $householdShare;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HouseholdShare $householdShare)
    {
        $this->householdShare = $householdShare;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.household.share_revoked');
    }
}
