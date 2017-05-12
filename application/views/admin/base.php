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
    <meta name="theme-color" content="#0099aa"/>
    <?php startblock('meta') ?><?php endblock() ?>
    <title><?php startblock('title') ?><?php endblock() ?></title>
    <link rel="icon" href="/assets/img/logo.png">

    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/fontello.css">
    <link rel="stylesheet" href="/assets/css/animation.css">
    <link rel="stylesheet" href="/assets/css/select2.css">
    <link rel="stylesheet" href="/assets/slick/slick.css">
    <link rel="stylesheet" href="/assets/slick/slick-theme.css">

    <link href="/assets/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/cropper/dist/cropper.css">

    <!-- end of global css -->
    <link rel="stylesheet" href="/assets/datatables/media/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="/assets/datatables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/assets/jquery-confirm/css/jquery-confirm.css">

    <style type="text/css">
        .ndropdown-menu {
            background: #0099aa;
            border: none;
            -webkit-box-shadow: -1px 8px 13px -2px rgba(4, 99, 110, 1);
            -moz-box-shadow: -1px 8px 13px -2px rgba(4, 99, 110, 1);
            box-shadow: -1px 8px 13px -2px rgba(4, 99, 110, 1);
        }

        .ndropdown-menu a {
            color: #fff;
        }

        .navbar-nav li {
            color: #fff;
        }

        .navbar-nav li a:hover {
            background: #f40f4b;
            color: #fff;
        }

        #data-table, #data-table thead tr th, #data-table tfoot tr th {
            text-align: center;
        }

        #data-table tfoot {
            display: table-header-group;
        }

    </style>


</head>
<body>


<nav class="navbar navbar-inverse" style="background-color: rgba(4, 99, 110, 1)">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="/assets/img/logo.png" width="60" style="margin-top: -10px;"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a class="nav-link" href="<?php echo base_url() ?>" style="color: #fff;">Web</span></a>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Peliculas <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo base_url('admin/nueva-pelicula') ?>">Nueva
                                Pelicula</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('admin/peliculas') ?>">Lista de
                                peliculas</a></li>

                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Series <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo base_url('admin/nueva-serie') ?>">Nueva Serie</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('admin/series') ?>">Lista de series</a></li>

                    </ul>
                </li>




                <li >
                    <a  href="<?php echo base_url('admin/categorias') ?>"
                       style="color: #fff;">Generos</span></a>
                </li>


                <li>
                    <a href="<?php echo base_url('admin/users') ?>"
                       style="color: #fff;">Usuarios</span></a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Administrador <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="icon-desktop"></i> Mi cuenta</a></li>
                        <li><a class="dropdown-item" href="#"><i class="icon-cog"></i> Ajustes</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('logout') ?>"><i class="icon-logout"></i> Cerrar
                                Sesión</a></li>



                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>



<?php startblock('main-content') ?><?php endblock() ?>


<footer class="text-center" style="background-color: #0099aa; padding: 20px;">

    <h2 style="color: white;">Peliculas y series en hd, sin publicidad</h2>
    <hr>

    <p style="color: white;">Moviseries no se responsabilisa por el mas uso del contenido <br> de esta web por parte de
        algunos usuarios</p>


</footer>


<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/bootstrap.js"></script>
<script src="/assets/slick/slick.js"></script>
<script src="/assets/js/select2.js"></script>
<script src="/assets/js/notify.js"></script>
<script src="/assets/ckeditor/ckeditor.js"></script>
<script src="/assets/cropper/dist/cropper.js"></script>
<script src="/assets/jquery-confirm/js/jquery-confirm.js"></script>
<script src="/assets/datatables/media/js/jquery.dataTables.min.js"></script>

<?php startblock('scripts') ?><?php endblock() ?>
</body>
</html>