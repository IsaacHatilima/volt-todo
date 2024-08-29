<x-mail::message>
# A very Productive welcome!

Hi {{ $profile->first_name }}, welcome to ToDo Ultimate, let us help you get productive. 🥳📆

To begin jotting down your todos, verify your email by clicking the button below. If that's is not working for you, there is a link below that.

Link expires in 30 minutes.

<x-mail::button url="{{ $url }}">
Verify
</x-mail::button>

Link: <br> {{ $url }}

Happy jotting,<br>
{{ config('app.name') }} Team
</x-mail::message>
