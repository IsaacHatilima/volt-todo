<x-mail::message>
# Password Reset

Hi {{ $user->profile->first_name }},

You recently requested for password reset. Click the button below to set a new password. If this was not you, you can ignore this email.

The link expires in 30 minutes.

<x-mail::button url="{{ $url }}">
    Reset Password
</x-mail::button>

Link:<br> {{ $url }}

Happy jotting,<br>
{{ config('app.name') }} Team
</x-mail::message>
