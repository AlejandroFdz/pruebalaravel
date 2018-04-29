@component('mail::message')
# Correo Hormiga

Han hecho un nuevo comentario en un ticket de soporte. Por favor, revísalo.

@component('mail::button', ['url' => 'http://correo.hormiga/tickets/'.$ticket_id.'/edit'])
Ver Comentario
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
