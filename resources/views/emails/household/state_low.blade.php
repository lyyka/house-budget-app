@component('mail::message')
We are sending this notification to you because the current balance of your household {{ $household->name }} is low. It is either less than 0 or less than your estimate monthly savings.
<br>
Additionally, we have attached your households current month expenses exported to Excel(.xlsx) table for you to look if you need to.

@component('mail::button', ['url' => env('APP_URL') . '/households/' . $household->id])
    View household dashboard and manage expenses
@endcomponent

You can always turn off this notification by going to your household dashboard and opening up the household settings.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
