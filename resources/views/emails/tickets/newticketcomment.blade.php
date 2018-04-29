@component('mail::message')
# Correo Hormiga

**Correo Hormiga** escribió un comentario en un ticket de soporte que publicaste.

@component('mail::button', ['url' => 'http://correo.hormiga/tickets/'.$ticket_id.'/edit'])
Ver Comentario
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
