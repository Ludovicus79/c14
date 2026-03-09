<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}" />
    @yield('headers')

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nuevo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navBarStyle.css') }}">
    @yield('estilos')

    <title>NAPROC 13 Base de datos de Carbono 13 de Productos Naturales</title>
    <script src="//code.jquery.com/jquery-2.1.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        // Solo resetear el filtro si no hay selecciones guardadas
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var path = window.location.pathname || '';
                if (path.indexOf('/search/') === 0) {
                    var selectedData = localStorage.getItem('SelectedData');
                    if (!selectedData || selectedData.length === 0) {
                        localStorage.setItem('FilterOnlySelected', 'false');
                    }
                }
            } catch (e) {}
        });

        // Función para limpiar selecciones al ir al historial
        function clearSelectionsOnHistory() {
            try {
                localStorage.removeItem('SelectedData');
                localStorage.setItem('FilterOnlySelected', 'false');
            } catch (e) {
                // Ignorar si el navegador bloquea localStorage
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var idioma = "{!! App::getLocale() !!}";

            if (idioma.indexOf("en") > -1) {
                $("#in").removeClass("inactive");
            } else if (idioma.indexOf("pt") > -1) {
                $("#po").removeClass("inactive");
            } else if (idioma.indexOf("de") > -1) {
                $("#al").removeClass("inactive");
            } else if (idioma.indexOf("fr") > -1) {
                $("#fr").removeClass("inactive");
            } else if (idioma.indexOf("it") > -1) {
                $("#it").removeClass("inactive");
            } else {
                $("#es").removeClass("inactive");
          } else if (idioma.indexOf("zh") > -1) {
                $("#zh").removeClass("inactive");
            }

            var docHeight = $(window).height();
            var footerHeight = $('footer').height();
            var footerTop = $('footer').position().top + footerHeight;
            if (footerTop < docHeight) {
                $('footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
            }
        });
    </script>
    @yield('scripts')
    
    <!-- reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<header class="container-fluid">
    <div class="row" id="barraSup">
        <div class="col-md-3 col-xs-12 text-center">
            <ul class="list-inline">
                <li>
                    <a href="{!! route('lang.switch', 'es') !!}">
                        <img id="es" class="logo inactive" src="{!! asset('images/esp.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'en') !!}">
                        <img id="in" class="logo inactive" src="{!! asset('images/eng.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'fr') !!}">
                        <img id="fr" class="logo inactive" src="{!! asset('images/fr.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'de') !!}">
                        <img id="al" class="logo inactive" src="{!! asset('images/ger.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'it') !!}">
                        <img id="it" class="logo inactive" src="{!! asset('images/ita.png') !!}" alt="">
                    </a>
                </li>
                <li>
                    <a href="{!! route('lang.switch', 'pt') !!}">
                        <img id="po" class="logo inactive" src="{!! asset('images/pt.png') !!}" alt="">
                    </a>
                </li>
                
                <li> 
                <a href="{!! route('lang.switch', 'zh') !!}">
                        <img id="zh" class="logo inactive" src="{!! asset('images/zh.png') !!}" alt="">
                    </a>
                        </li>
            </ul>
        </div>
        <div class="col-md-offset-4 col-md-5 col-xs-12 text-center">
            <ul class="list-inline">
                @guest
                    <li><img class="logo" src="{!! asset('images/login.png') !!}" alt="login"></li>
                    <li><a href="{{ url('login') }}">{!! trans('applicationResource.menu.sesion') !!}</a></li>
                    <li><a href="{{ url('register') }}">{!! trans('applicationResource.menu.signUp') !!}</a></li>
                @else
                    <li class="col-md-5" style="color:white; font-weight: bold">{!!trans('applicationResource.user.user')!!} {!! Auth::user()->name !!}</li>
                    <li><a href="{{ url('logout') }}">{!! trans('applicationResource.menu.logout') !!}</a></li>
                    @if(Auth::user()->allowed)
                        <li><a href="{{ url('admin') }}">{!! trans('applicationResource.menu.admin') !!}</a></li>
                    @endif
                @endguest
            </ul>
        </div>
    </div>
    <div class="row">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/"><img class="img-responsive" src="{!! asset('images/naproclogo.png') !!}"
                                     alt="Naproc 13"></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"
                               href="">{!! trans('applicationResource.menu.busqueda') !!} <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('search/byName') }}">{!! trans('applicationResource.submenu.nombre') !!}</a></li>
                                <li><a href="{{ url('search/bySubstructure') }}">{!! trans('applicationResource.submenu.subestructura') !!}</a></li>
                                <li><a href="{{ url('search/byShiftNoPosition') }}">{!! trans('applicationResource.submenu.desplazamiento') !!}</a></li>
                                <li><a href="{{ url('search/byCarbonType') }}">{!! trans('applicationResource.submenu.tipocarbono') !!}</a></li>
                            </ul>
                        </li>
                        <li class="liCabecera"><a href="history" onclick="clearSelectionsOnHistory()">{!! trans('applicationResource.menu.historial') !!}</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="wrapper">
    @yield('mainContainer')
</div>

<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-offset-1 col-md-2 vcenter">
            <a href="http://www.usal.es"><img class="img-responsive center-block" src="{!! asset('images/Logo_Usal_Hor_Eng_Blanco_2011.png') !!}" alt="logo"/></a>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-2 text-center vcenter">
            <ul class="list-unstyled">
                <li><a href="{{ url('contributors') }}">{!! trans('applicationResource.menu.colaboradores') !!}</a></li>
                <li><a href="{{ url('developers') }}">{!! trans('applicationResource.menu.developers') !!}</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-2 text-center vcenter">
            <ul class="list-unstyled">
                <li><a href="{{ url('help') }}">{!! trans('applicationResource.menu.ayuda') !!}</a></li>
                <li><a href="{{ url('acknowledgment') }}">{!! trans('applicationResource.menu.agradecimientos') !!}</a></li>
                <li><a href="{{ url('conditions') }}">{!! trans('applicationResource.menu.condiciones') !!}</a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-4 text-center text-white vcenter">
            <p>Dpto. de Ciencias Farmacéuticas <br>
            Dr. José Luis López Pérez <br>
            <a href="mailto:lopez@usal.es">lopez@usal.es</a>
            </p>
        </div>
    </div>
</footer>
</body>
</html>