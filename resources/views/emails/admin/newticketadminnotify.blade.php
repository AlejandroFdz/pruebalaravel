@component('mail::message')
# Nuevo ticket creado en **Correo Hormiga**

Se ha creado un nuevo ticket en **Correo Hormiga**. Accede para revisarlo.

@component('mail::button', ['url' => 'http://correo.hormiga/tickets'])
Correo Hormiga
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
