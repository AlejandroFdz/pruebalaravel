@component('mail::message')
# Correo Hormiga

Gracias por registrarte y usar **Correo Hormiga**. ¡Esperamos que el email marketing
de tu empresa funcione de maravilla con nosotros!

@component('mail::button', ['url' => 'http://correo.hormiga'])
Empezar
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
