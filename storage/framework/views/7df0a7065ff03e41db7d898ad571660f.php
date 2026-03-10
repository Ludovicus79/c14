<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>" />
    <?php echo $__env->yieldContent('headers'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/nuevo.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">   <!-- añadir esta -->
    <link rel="stylesheet" href="<?php echo e(asset('css/navBarStyle.css')); ?>">
    <?php echo $__env->yieldContent('estilos'); ?>

    <title>NAPROC 13 Base de datos de Carbono 13 de Productos Naturales</title>
    <script src="//code.jquery.com/jquery-2.1.2.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
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
            var idioma = "<?php echo App::getLocale(); ?>";

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
            } else if (idioma.indexOf("zh") > -1) {
                $("#zh").removeClass("inactive");
            } else {
                $("#es").removeClass("inactive");
            }

            var docHeight = $(window).height();
            var footerHeight = $('footer').height();
            var footerTop = $('footer').position().top + footerHeight;
            if (footerTop < docHeight) {
                $('footer').css('margin-top', 10 + (docHeight - footerTop) + 'px');
            }
        });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
    
    <!-- reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<header class="container-fluid">
    <div class="row" id="barraSup">
        <div class="col-md-3 col-xs-12 text-center">
            <ul class="list-inline">
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'es']); ?>">
                        <img id="es" class="logo inactive" src="<?php echo asset('images/esp.png'); ?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'en']); ?>">
                        <img id="in" class="logo inactive" src="<?php echo asset('images/eng.png'); ?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'fr']); ?>">
                        <img id="fr" class="logo inactive" src="<?php echo asset('images/fr.png'); ?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'de']); ?>">
                        <img id="al" class="logo inactive" src="<?php echo asset('images/ger.png'); ?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'it']); ?>">
                        <img id="it" class="logo inactive" src="<?php echo asset('images/ita.png'); ?>" alt="">
                    </a>
                </li>
                <li>
                    <a href="<?php echo route('lang.switch', ['lang' => 'pt']); ?>">
                        <img id="po" class="logo inactive" src="<?php echo asset('images/pt.png'); ?>" alt="">
                    </a>
                </li>
                
                <li> 
                <a href="<?php echo route('lang.switch', ['lang' => 'zh']); ?>">
                        <img id="zh" class="logo inactive" src="<?php echo asset('images/zh.png'); ?>" alt="">
                    </a>
                        </li>
            </ul>
        </div>
        <div class="col-md-offset-4 col-md-5 col-xs-12 text-center">
            <ul class="list-inline">
                <?php if(auth()->guard()->guest()): ?>
                    <li><img class="logo" src="<?php echo asset('images/login.png'); ?>" alt="login"></li>
                    <li><a href="<?php echo e(url('login')); ?>"><?php echo trans('applicationResource.menu.sesion'); ?></a></li>
                    <li><a href="<?php echo e(url('register')); ?>"><?php echo trans('applicationResource.menu.signUp'); ?></a></li>
                <?php else: ?>
                    <li class="col-md-5" style="color:white; font-weight: bold"><?php echo trans('applicationResource.user.user'); ?> <?php echo Auth::user()->name; ?></li>
                    <li><a href="<?php echo e(url('logout')); ?>"><?php echo trans('applicationResource.menu.logout'); ?></a></li>
                    <?php if(Auth::user()->allowed): ?>
                        <li><a href="<?php echo e(url('admin')); ?>"><?php echo trans('applicationResource.menu.admin'); ?></a></li>
                    <?php endif; ?>
                <?php endif; ?>
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
                    <a href="/"><img class="img-responsive" src="<?php echo asset('images/naproclogo.png'); ?>"
                                     alt="Naproc 13"></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"
                               href=""><?php echo trans('applicationResource.menu.busqueda'); ?> <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo e(url('search/byName')); ?>"><?php echo trans('applicationResource.submenu.nombre'); ?></a></li>
                                <li><a href="<?php echo e(url('search/bySubstructure')); ?>"><?php echo trans('applicationResource.submenu.subestructura'); ?></a></li>
                                <li><a href="<?php echo e(url('search/byShiftNoPosition')); ?>"><?php echo trans('applicationResource.submenu.desplazamiento'); ?></a></li>
                                <li><a href="<?php echo e(url('search/byCarbonType')); ?>"><?php echo trans('applicationResource.submenu.tipocarbono'); ?></a></li>
                            </ul>
                        </li>
                        <li class="liCabecera"><a href="history" onclick="clearSelectionsOnHistory()"><?php echo trans('applicationResource.menu.historial'); ?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="wrapper">
    <?php echo $__env->yieldContent('mainContainer'); ?>
</div>

<footer class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-offset-1 col-md-2 vcenter">
            <a href="http://www.usal.es"><img class="img-responsive center-block" src="<?php echo asset('images/Logo_Usal_Hor_Eng_Blanco_2011.png'); ?>" alt="logo"/></a>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-2 text-center vcenter">
            <ul class="list-unstyled">
                <li><a href="<?php echo e(url('contributors')); ?>"><?php echo trans('applicationResource.menu.colaboradores'); ?></a></li>
                <li><a href="<?php echo e(url('developers')); ?>"><?php echo trans('applicationResource.menu.developers'); ?></a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-2 text-center vcenter">
            <ul class="list-unstyled">
                <li><a href="<?php echo e(url('help')); ?>"><?php echo trans('applicationResource.menu.ayuda'); ?></a></li>
                <li><a href="<?php echo e(url('acknowledgment')); ?>"><?php echo trans('applicationResource.menu.agradecimientos'); ?></a></li>
                <li><a href="<?php echo e(url('conditions')); ?>"><?php echo trans('applicationResource.menu.condiciones'); ?></a></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-4 text-center text-white vcenter">
            <p>Dpto. de Ciencias Farmacéuticas <br>
            Dr. José Luis López Pérez <br>
            <a href="/cdn-cgi/l/email-protection#5f33302f3a251f2a2c3e33713a2c"><span class="__cf_email__" data-cfemail="771b18071<?php /**PATH C:\c14-main\resources\views/layouts/master.blade.php ENDPATH**/ ?>