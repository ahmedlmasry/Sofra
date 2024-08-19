<x-mail::message>
# Introduction

Sofra Reset Password

<p>Hello {{$client->name}}</p>

<p> your reset code is : {{$client->pin_code}} </p>
{{--<x-mail::button :url="''">--}}
{{--Button Text--}}
{{--</x-mail::button>--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
