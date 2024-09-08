<x-mail::message>
# 2FA Notice

Hi {{ $user->profile->first_name }}, your Two Factor Authentication Code is: **{{ $code }}**

Happy jotting,<br>
{{ config('app.name') }} Team
</x-mail::message>
