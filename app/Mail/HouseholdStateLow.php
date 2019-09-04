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
    public $path_to_report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Household $household, $path_to_report)
    {
        $this->household = $household;
        $this->path_to_report = $path_to_report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.household.state_low')
        ->attachFromStorage($this->path_to_report);
    }
}
