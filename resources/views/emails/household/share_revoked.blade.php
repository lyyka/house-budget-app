@component('mail::message')
We are informing you that {{ $householdShare->household->owner->first_name . ' ' .  $householdShare->household->owner->last_name}} has revoked your access to the household <strong>{{ $householdShare->household->name }}</strong>. You no longer can view the household in you "Share households list" and do not have any kind of access to it.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
