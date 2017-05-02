<?php
$token = password_hash("token", PASSWORD_DEFAULT);
$_SESSION['token'] = $token;
?>
<?php require_once 'ti.php' ?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#025aa5"/>
    <?php startblock('meta') ?><?php endblock() ?>
    <title><?php startblock('title') ?><?php endblock() ?></title>
    <link rel="icon" href="/assets/img/logo.png">

    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/material.css">
    <link rel="stylesheet" href="/assets/css/fontello.css">
    <link rel="stylesheet" href="/assets/css/animation.css">
    <link rel="stylesheet" href="/assets/css/ap-fullscreen-modal.css">
    <link rel="stylesheet" href="/assets/css/plyr.css">
    <link rel="stylesheet" href="/assets/css/hover.css">
    <link rel="stylesheet" href="/assets/slick/slick.css">
    <link rel="stylesheet" href="/assets/slick/slick-theme.css">


    <!--mis estilos -->
    <link rel="stylesheet" href="/assets/mis_css/style.css">

    <style>


        .mpagination span {
            padding: 10px;
            border: 2px solid #0099cc;
        }

        /* CUSTOM SCROLLBAR */
        ::-webkit-scrollbar,
        ::-webkit-scrollbar:horizontal {
            width: 15px;
        }

        ::-webkit-scrollbar {
            background: #FFD6C8;
        }

        /* DISABLED STATES */
        ::-webkit-scrollbar:disabled {
            background: #f40f4b;
            border-left: 1px solid #FFD6C8;
        }

        /* HANDLE */
        ::-webkit-scrollbar-thumb,
        ::-webkit-scrollbar-thumb:window-inactive,
        ::-webkit-scrollbar-thumb:disabled {
            background: #f40f4b;
            width: 15px;
            border-left: 1px solid #FFD6C8;
            visibility: visible;
        }

        .list-group-item:hover a {
            color: white;
            text-decoration: none;
        }

        .list-group-item.active a {
            color: white;
            text-decoration: none;
        }

        /* styles for desktop */
        .tinynav {
            display: none;
            width: 100%;
            padding: 10px;
            border: 2px solid #eb0f4b;
        }

        /* styles for mobile */
        @media screen and (max-width: 767px) {
            .tinynav {
                display: block
            }

            #categorias {
                display: none
            }
        }

        .slider {
            width: 100%;
            margin: 10px auto;
        }

        .slick-prev {
            left: 10px;
            z-index: 9;
        }

        .slick-next {
            right: 10px;
            z-index: 9;
        }

        .slick-slide {
            margin: 0px 5px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }

        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript,
        if it's not present, don't show loader */
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(/assets/img/loading2.gif) center no-repeat #fff;
        }

    </style>

</head>
<body>


<div style="background-color: #1A237E; ">
    <!-- Header -->
    <div id="header" class="container-fluid">
        <h1 id="logo" class="pl-2"><img src="/assets/img/logo.png" alt="" width="100"></h1>

        <button class="nav-toggle"><i class="icon-th-large-outline"></i></button>


        <!-- Navigation -->
        <div id="navigation">


            <ul class="hidden-md-down" style="float: left;">
                <li><a target="_blank" href="https://www.facebook.com/Moviseries-1899211867018896/"><i
                            class="icon-facebook"></i></a></li>
                <li><a target="_blank" href="https://plus.google.com/113692407905589602086"><i class="icon-google"></i></a></li>
                <li><a target="_blank" href="https://www.youtube.com/channel/UCSs7eO5SAkvoofRNMvFdETA"><i class="icon-youtube"></i></a></li>
            </ul>

            <ul style="float: right;">
                <li><a id="search-movie-serie" href="javascript:;"><i class="icon-search-1"></i></a></li>

                <?php if (!isset($_SESSION['username'])) { ?>
                    <li style="float: right"><a id="open-login" href="javascript:;"><i
                                class="icon-users-1"></i>Usuarios</a></li>


                    <div style="display: none;">
                        <div id="modal-login" class="">
                            <div class="p-5 offset-lg-3 col-lg-6  offset-md-1 col-md-10">

                                <!-- Begin # DIV Form -->
                                <div id="div-forms">

                                    <!-- Begin # Login Form -->
                                    <form id="login-form" action="<?php echo base_url('login') ?>">
                                        <div class="modal-body">

                                            <div id="div-login-msg" class="text-center">
                                                <h3 id="text-login-msg"><b>INGRESO AL SISTEMA</b></h3>
                                            </div>

                                            <input type="text" name="token" value="<?php echo $token ?>" hidden>

                                            <div class="text-center">
                                                <img id="gif-login" src="/assets/img/loading2.gif" width="80"
                                                     style="display: none">
                                                <b id="result-login" class="alert alert-info"
                                                   style="display: none"></b>
                                            </div>

                                            <div class="clearfix"></div>


                                            <label for="login_username" class="text-left">E-mail</label>
                                            <input name="email" id="login_username" class="form-control"
                                                   type="email"
                                                   placeholder="Email: miemail@gmail.com" required>

                                            <br>
                                            <label for="login_passwor">Contraseña</label>

                                            <div class="row">
                                                <div class="col-sm-10 col-9 pr-0">
                                                    <input name="password" id="login_password"
                                                           class="form-control"
                                                           type="password"
                                                           placeholder="Contraseña" required>
                                                </div>
                                                <div class="col-sm-2  col-3 pl-0">
                                                    <button onclick="show_password('login_password')"
                                                            class="btn btn-block" type="button"><i
                                                            class="icon-eye-1 icon-show-pass"></i></button>
                                                </div>
                                            </div>
                                            <br>

                                            <div>
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="icon-login"></i> Ingresar
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                            <div>
                                                <button id="login_lost_btn" type="button" class="btn btn-link">
                                                    <i class="icon-key"></i> Olvido su
                                                    contraseña?
                                                </button>
                                                <button id="login_register_btn" type="button" class="btn btn-link">
                                                    <i class="icon-user-add"></i> Registrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End # Login Form -->

                                    <!-- Begin | Lost Password Form -->
                                    <form id="lost-form" action="<?php echo base_url('reset-password') ?>"
                                          style="display:none;">
                                        <div class="modal-body">

                                            <h3><b>RECUPERACCIÓN DE CONTRASEÑA</b></h3>

                                            <input type="text" name="token" value="<?php echo $token ?>" hidden>

                                            <div class="text-center p-2">
                                                <img id="gif-lost" src="/assets/img/loading2.gif" width="80"
                                                     style="display: none">
                                                <b id="result-lost" class="alert alert-info"
                                                   style="display: none"></b>
                                            </div>


                                            <div id="div-lost-msg">
                                                <div id="icon-lost-msg"
                                                     class="glyphicon glyphicon-chevron-right"></div>
                                                <b id="text-lost-msg">Ingrese su E-mail.</b>
                                            </div>
                                            <input id="lost_email" name="email" class="form-control" type="email"
                                                   placeholder="E-Mail con el que creo su cuenta" required>
                                            <br>

                                            <div>
                                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                    <i class="icon-play"></i> Enviar Solicitud
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                            <div>
                                                <button id="lost_login_btn" type="button" class="btn btn-link">
                                                    <i class="icon-login"></i> Iniciar Sesión
                                                </button>
                                                <button id="lost_register_btn" type="button" class="btn btn-link">
                                                    <i class="icon-user-add"></i> Registrar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End | Lost Password Form -->

                                    <!-- Begin | Register Form -->
                                    <form id="register-form" action="<?php echo base_url('new-user') ?>"
                                          style="display:none; ">
                                        <input type="text" name="token" value="<?php echo $token ?>" hidden>

                                        <div class="modal-body text-center">
                                            <div id="div-register-msg">
                                                <div id="icon-register-msg"
                                                     class="glyphicon glyphicon-chevron-right"></div>
                                                <h3 id="text-register-msg" style="text-transform: uppercase;"><b>Crear
                                                        una
                                                        nueva cuenta</b></h3>
                                            </div>

                                            <div class="text-center p-2">
                                                <img id="gif-register" src="/assets/img/loading2.gif" width="80"
                                                     style="display: none">
                                                <b id="result-register" class="alert alert-link"
                                                   style="display: none"></b>
                                            </div>

                                            <div class="clearfix"></div>

                                            <label for="">Usuario:</label>
                                            <input name="username" id="register_username" class="form-control"
                                                   type="text"
                                                   placeholder="Usuario" required>
                                            <br>
                                            <label for="">E-mail:</label>
                                            <input name="email" id="register_email" class="form-control"
                                                   type="email"
                                                   placeholder="E-Mail" required>
                                            <br>
                                            <label for="">Contraseña:</label>

                                            <div class="row">
                                                <div class="col-sm-10 col-9 pr-0">
                                                    <input name="password" id="register_password"
                                                           class="form-control"
                                                           type="password"
                                                           placeholder="Contraseña" required>
                                                </div>
                                                <div class="col-sm-2  col-3 pl-0">
                                                    <button onclick="show_password('register_password')"
                                                            class="btn btn-block" type="button"><i
                                                            class="icon-eye-1 icon-show-pass"></i></button>
                                                </div>
                                            </div>
                                            <br>

                                            <div>
                                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                    <i class="icon-user-add"></i> Registrar
                                                </button>
                                            </div>


                                        </div>
                                        <div>

                                            <div>
                                                <button id="register_login_btn" type="button" class="btn btn-link">
                                                    <i class="icon-login"></i> Iniciar Sesión
                                                </button>
                                                <button id="register_lost_btn" type="button" class="btn btn-link">
                                                    <i class="icon-key"></i> Olvido su contraseña?
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End | Register Form -->

                                </div>
                                <!-- End # DIV Form -->

                            </div>
                        </div>
                    </div>

                <?php } else {

                    if ($_SESSION['user_type'] == 'admin') {?>
                        <li><a href="<?php echo base_url('admin') ?>"><i
                                    class="icon-user"></i><?php echo $_SESSION['username'] ?>
                            </a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo base_url('mi-cuenta') ?>"><i
                                    class="icon-user"></i><?php echo $_SESSION['username'] ?>
                            </a></li>
                    <?php } ?>



                    <li><a href="<?php echo base_url('logout') ?>"><i
                                class="icon-logout-1"></i> Salir
                        </a></li>

                <?php } ?>
            </ul>


            <ul id="main-nav" style="float: right">

                <li><a id="nav-inicio" href="<?php echo base_url() ?>">INICIO</a></li>
                <li><a id="nav-peliculas" href="<?php echo base_url('peliculas') ?>">PELICULAS</a></li>
                <li><a id="nav-series" href="<?php echo base_url('series') ?>">SERIES</a></li>
                <li><a id="nav-android-app" href="<?php echo base_url('android-app') ?>">ANDROID APP</a></li>
                <li><a id="nav-premium" href="<?php echo base_url('premium') ?>">PREMIUM</a></li>
            </ul>


        </div>
        <!-- end Navigation -->

        <div class="clearfix"></div>

    </div>
    <!-- end Header -->

</div>
<div class="clearfix"></div>

<div id="main-content" class="container-fluid" style="background-color: white; padding-top: 75px;">
    <?php startblock('main-content') ?><?php endblock() ?>
</div>

<div style="display: none;">
    <div id="modal-search">
        <input id="search-link" type="text" hidden value="<?php echo base_url('suggestions') ?>">

        <div class="p-5">
            <br><br>

            <form action="<?php echo base_url('busqueda') ?>" method="get">
                <div class="row pl-3">
                    <div class="col-10 p-0">
                        <input id="input-search" type="text" name="query" class="form-control"
                               placeholder="buscar pelicula o serie ...">
                    </div>
                    <div class="col-2 p-0 mr-0">
                        <button type="submit" class="btn btn-primary"><i class="icon-search-1"></i></button>
                    </div>
                </div>
            </form>

            <div id="sugerencias">
            </div>

        </div>
    </div>
</div>

<footer class="" style="background-color: #1A237E; color: white; text-align: center; padding-top: 20px;">


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <b>Moviseries</b>

                <p>Este es un sitio de entretenimiento sin fines de lucro. No nos hacemos responsables por el mal uso
                    que se le de al material de nuestra web por parte de los usuarios.</p>


            </div>

            <div class="col-md-4">
                <b>CONTACTOS</b>

                <p><i class="fa fa-envelope"></i> moviserieshd@gmail.com</p>

                <div class="clearfix"></div>
                <hr>
                <b>&copy; Moviseries.xyz</b>
                <hr>
                <a style="font-size: 20px" target="_blank" class="btn btn-primary btn-circle btn-xl"
                   href="https://www.facebook.com/Moviseries-1899211867018896/"><i class="icon-facebook"></i></a>
                <a style="font-size: 20px" target="_blank" class="btn btn-danger btn-circle btn-xl"
                   href="https://plus.google.com/113692407905589602086"><i class="icon-google"></i></a>


                <p>Peliculas y series en HD sin publicidad</p>

                <p>Todos los derechos reservados</p>
            </div>


            <div class="col-md-4">
                <b>NUESTRA MISIÓN</b>

                <p>Sabemos que hay otras paginas web que ofrecen el mismo contenido, pero también sabemos cuan molesto
                    es la
                    publicidad exagerada. Queremos ofrecerte el mejor servicio libre de publicidad.</p>

            </div>


        </div>


    </div>
</footer>


<div style="bottom: 20px; right: 10px; position: fixed; z-index: 999;">
    <a id="toTop" href="javascript:;"
       style="display: none; border-radius: 50%; padding-bottom: 10px;;
        width: 40px; background-color: #f40f4b; color: white; padding: 10px;">
        <i class="icon-up-bold"></i>
    </a>
</div>


<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/js/material.js"></script>
<script src="/assets/js/plyr.js"></script>
<script src="/assets/js/ap-fullscreen-modal.js"></script>
<script src="/assets/slick/slick.js"></script>
<script src="/assets/js/tinynav.js"></script>

<script src="/assets/mis_js/custom_functions.js"></script>
<script src="/assets/mis_js/main.js"></script>

<?php startblock('scripts') ?><?php endblock() ?>
</body>
</html>