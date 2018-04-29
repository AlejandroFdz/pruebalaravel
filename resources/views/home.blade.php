<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Correo Hormiga') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <!-- Font awesome -->
    <script src="https://use.fontawesome.com/f4045ea5f5.js"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/webpage.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>

    <div id="app" class="container web-container">

        <div class="row topbar">
            <div class="col-md-4 logo">
                CORREO HORMIGA
            </div>
            <div class="col-md-8">

                <ul class="mainmenu">

                    @if( $is_mobile == 0 )
                      
                        @if (Auth::user() && Auth::user()->admin == 1)
                            <li>
                                <a href="{{route('admin.dashboard')}}">Administrar</a>
                            </li>
                            <li>
                                <a href="{{url('/blog')}}">Blog</a>
                            </li>
                            <li>
                                <a href="{{url('/tickets')}}">Soporte</a>
                            </li>
                        @else
                            @if (Auth::user())
                                <li>
                                    <a href="{{route('campaigns.index')}}" class="home-dashboard">Campañas</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url('/planes')}}">Planes</a>
                            </li>
                            <li>
                                <a href="{{url('/tickets')}}">Soporte</a>
                            </li>
                            <li>
                                <a href="{{url('blog')}}">Blog</a>
                            </li>
                        @endif

                        <li>
                            @if(Auth::user())
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Bienvenido/a, <strong>{{ Auth::user()->name }}</strong>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownAccount">
                                        <li><a href="{{route('user.profile')}}">Mi cuenta</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="/logout" class="logout">Cerrar sesión</a></li>
                                    </ul>
                                </div>
                                <!-- <a href="#" class="account">Bienvenido/a, <strong>{{ Auth::user()->name }}</strong></a><br />
                                <a href="/logout" class="logout">Cerrar sesión</a> -->
                            @else
                                <a href="/acceso" class="login">Acceder</a>
                            @endif
                        </li>
                    @else
                        <li>
                            <a href="{{url('blog')}}">Blog</a>
                        </li>
                    @endif
                </ul>

            </div>
        </div>

        <div class="home-slide text-center">
            <h1>Envía correo mejor y vende más</h1>
        </div>

        <div class="row section home-section-2">

            <div class="col-md-1"></div>

            <div class="col-md-5">

                <h2>¿Por qué funciona el envío de correos en tu negocio?</h2><br>

                Conocer el número de prospectos o personas a las que llegan tus avisos y promociones es la mejor manera de comenzar a incrementar las utilidades de tu negocio. No puedes mejorar lo que no se mide y con Correo Hormiga las mediciones de mercadotecnia están cubiertas.
                <br><br>
                Aumenta el número de transacciones promedio que haces con tus clientes. Está comprobado que el 70% de los clientes que cambian de proveedor o negocio preferido lo hace porque siente un grado de indiferencia con relación a la marca… Estar en constante comunicación con tus clientes te permitirá saber cosas como:
                <br><br>
                ¿Qué tan satisfecho están tus clientes?, ¿cuántas veces te han comprado en cierto periodo de tiempo?, ¿te recomendarían si se los pides?, ¿cuál es el tiempo de vida de tus clientes?, ¿cuál es el costo de adquisición de un nuevo cliente?….
                <br><br>
                El primer paso es registrarte sin costo a Correo Hormiga.

            </div>

            <div class="col-md-5">
                <img src="imgs/webpage/video-promocional.jpg" class="video-promo" alt="" width="85%">
            </div>

        </div>

        <div class="row section home-section-3 text-center">
            <h2>Características y Beneficios</h2>
        </div>

        <div class="row section home-section-4">
            <div class="col-md-2"></div>
            <div class="col-md-8 section-4">
                <div class="col-md-6">
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Mediciones de mercadotecnia.</h3>
                            Identifica mejoras en tu sistema de ventas por pasos, y si no cuentas con uno, Correo Hormiga es la mejor herramienta para comenzar a construirlo. Obtén tasas de conversión automáticas y conoce quién abre tus correos y se interesa por tu oferta.
                            <br><br>
                            <span class="sub-feature">Primer mes gratis</span>
                        </div>
                    </div>
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Envío masivo de correos.</h3>
                            ¿Comunicación con tus clientes, prospectos y colaboradores? En Correo Hormiga lo tienes cubierto, da a conocer tu catálogo de productos o servicios, llega a los prospectos más calificados para tu negocio y mantén a tu equipo motivado y alineado a través de comunicación efectiva.
                        </div>
                    </div>
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Manuales en video.</h3>
                            Lo único que requieres en Correo Hormiga es tener pasión por ver crecer tu negocio, las herramientas para lograrlo las tienes aquí. Con los manuales en video y sistema de soporte por tickets resolveremos tus dudas sistemáticamente de manera personalizada.
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Editor de correo electrónico.</h3>
                            Tu mensaje llegará a muchas personas... y lo hará con estilo. Utiliza el editor de correos para crear hermosas piezas de correo para el envío de tus mensajes, la idea es mantener una identidad corporativa para tu negocio que de confianza y garantía a tus clientes y prospectos.
                        </div>
                    </div>
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Sistematización de cómo hacer las cosas.</h3>
                            ¿Piensas que nadie hace las cosas mejor que tu en el negocio? La verdad es que tienes razón, por que solamente tu sabes cómo es ese negocio exitoso que tienes en la mente. ¿Qué te parece darle el visto bueno a la campaña de mercadotecnia por correo electrónico y dejar que tu gente envíe estos diseños y mensajes que tu aprobaste cada vez que se requiera? No esperes más e inicia con Correo Hormiga.
                        </div>
                    </div>
                    <div class="row section-4-mod">
                        <div class="col-md-1">
                            <i class="fa fa-rocket" aria-hidden="true"></i>
                        </div>
                        <div class="col-md-11 feature">
                            <h3>Plataforma en español.</h3>
                            Generalmente las herramientas más poderosas e interesantes de mercadotecnia se encuentran medianamente traducidas del inglés, alemán o cualquier otro idioma diferente al español. En Correo Hormiga garantizamos que nuestro contenido, manuales, videos y la herramienta en general se encuentra pensada exclusivamente para el mercado de habla hispana.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="row section home-section-5 text-center">
            <img src="imgs/webpage/plane.jpg" alt="" class="plane" width="120px">
        </div>

        <div class="row section footer">

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 title-footer text-center">
                    <h2>Empieza ahora con correo hormiga</h2>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt.
                    <a href="/registro" class="btn btn-primary" style="width:200px;">REGÍSTRATE GRATIS</a>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="row" style="padding: 0 15px 0 15px !important;">
                <div class="col-md-3 footer-column">

                    <h2>LOGO</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua.<br><br></p>

                    <a href="#" target="_blank">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                    <a href="#" target="_blank">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                    <a href="#" target="_blank">
                        <i class="fa fa-google-plus" aria-hidden="true"></i>
                    </a>
                    <a href="#" target="_blank">
                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                    </a>

                </div>
                <div class="col-md-8"></div>
            </div>

            <div class="row sub-footer" style="padding: 0 15px 0 15px !important;">
                <div class="col-md-6">
                    <strong>Correo Hormiga 2017</strong> · Todos los Derechos Reservados
                </div>
                <div class="col-md-6 text-right">
                    Política de privacidad · Términos de uso
                </div>
            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
