<x-mail::message>

    Hello, an account has been created for you for the site {{ config('app.name') }} !
    To log in to your account, you need to confirm your email (the confirmation link will be in the next letter)
    Your password for the account:: {{$password}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
