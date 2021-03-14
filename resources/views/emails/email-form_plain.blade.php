{{ $text_content }}

Sent using ,<br>
{{ config('app.name') }}

Having any problems reading this email? Open the following url:
{{ route('email.open_in_browser', ['email' => $email_id]) }}
