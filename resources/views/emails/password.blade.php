@component('mail::message')
    # Reset Password

    Your six-digit CODE is <h4>{{ $code }}</h4>
    <p>Please do not share your One Time Pin With Anyone. You made a request to reset your password. Please discard if this
        wasn't you.</p>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
