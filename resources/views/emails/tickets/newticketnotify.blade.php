@component('mail::message')
# Soporte técnico de **Correo Hormiga**

Tu ticket se creó con éxito. El equipo técnico de **Correo Hormiga** se encargará de revisarlo
y te notificará cuando revisen la incidencia.

@component('mail::button', ['url' => 'http://correo.hormiga'])
Correo Hormiga
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
