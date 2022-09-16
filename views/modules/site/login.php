<?php
require_once("../../../app/Controllers/UsuariosController.php");
require_once("../../partials/routes.php");

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Login</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition login-page">


<!-- barra -->
<div class="menu">
        <h1 class="text-orange"> <strong>¡Bienvenidos!</strong></h1>
        <p class="text-white">Esperamos que sea gratificante el uso de este sistema</p>
</div>


<div class="card-body" id="mensaje">
    <img src="<?= $baseURL ?>/views/public/img/terminal.png" class="img-responsive elevation" alt="Imagen principal">
 </div>


    <!-- /.login-logo -->
    <div class="card" id="contenedor-login">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Ingrese sus datos para iniciar sesión</p>
            <form action="../../../app/Controllers/MainController.php?controller=Usuarios&action=login" method="post">
                <div class="input-group mb-3">
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="usuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user bg-white"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock bg-white"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn bg-orange btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
                <br>
                <?php if (!empty($_GET['respuesta'])) { ?>
                    <?php if ( !empty($_GET['respuesta']) && $_GET['respuesta'] != "correcto" ) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error al Ingresar: </h5> <?= $_GET['mensaje'] ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>

        </div>

    </div>
</div>

<?php require('../../partials/scripts.php'); ?>

</body>
</html>