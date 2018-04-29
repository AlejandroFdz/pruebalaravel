@component('mail::message')
# Correo Hormiga

Todos los correos se enviaron a sus destinatarios con éxito. Podrá consultar las estadísticas de aperturas e interacciones
desde su cuenta de usuario en Correo Hormiga. 

@component('mail::button', ['url' => 'http://correo.hormiga'])
Correo Hormiga
@endcomponent

Gracias por usar nuestro servicio,
{{ config('app.name') }}
@endcomponent
