@component('mail::message')
{{ $owner->first_name . ' ' . $owner->last_name }} shared a household <strong>{{ $household->name }}</strong> with you.
<br>
<br>
{{ $owner->first_name }} specified this email to share the household with. {!! $user_exists ? "Just log in to your account and go to <a href = 'http://www." . evn("APP_URL") . "/households'>Households</a> page. At the bottom of the page you will find households that are shared with you, including this one." : "In order to manage the household, you just have to create an account with this email on our website <a href = 'http://www." . env("APP_URL") . "/register'>" . env("APP_URL") . "</a> and log in." !!}

@if ($user_exists)
@component('mail::button', ['url' => 'http://' . env('APP_URL') . '/households'])
    View Households
@endcomponent
@else
@component('mail::button', ['url' => 'http://' . env('APP_URL') . '/register'])
    5 Minute Registration Process
@endcomponent
@endif


Thanks,<br>
{{ config('app.name') }}
@endcomponent
