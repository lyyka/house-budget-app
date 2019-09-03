<?php

namespace App\Mail;

use App\Household;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HouseholdStateLow extends Mailable
{
    use Queueable, SerializesModels;

    public $household;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Household $household)
    {
        $this->household = $household;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.household.state_low');
    }
}
