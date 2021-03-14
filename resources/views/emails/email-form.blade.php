{!! $html_content !!}
Sent using ,<br>
{{ config('app.name') }}

Having any problems reading this email? <a href="{{ route('email.open_in_browser', ['email' => $email_id]) }}"> Open in browser</a>

