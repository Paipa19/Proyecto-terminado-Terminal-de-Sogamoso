<?php


require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/UsuariosController.php");


use App\Controllers\UsuariosController;
use App\Models\GeneralFunctions;
use App\Models\Usuarios;
use Carbon\Carbon;


$nameModel = "Usuario";
$nameForm = 'frmEdit'.$nameModel;
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION[$nameForm] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE']  ?> | Editar <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><strong>EDITAR INFORMACIÓN DEL USUARIO</strong></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-white">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp;<strong> Información del usuario</strong></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn- text-white" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn- text-white" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn- text-white" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php

                                $DataUsuario = UsuariosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataUsuario Usuarios */
                                if (!empty($DataUsuario)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataUsuario->getId(); ?>"
                                                   hidden required="required" type="text">

                                            <div class="form-group row">
                                                <label for="documento" class="col-sm-2 col-form-label">Documento </label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="documento"
                                                           name="documento" value="<?= $DataUsuario->getDocumento(); ?>"
                                                           placeholder="Ingrese su documento">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="nombre"
                                                           name="nombre" value="<?= $DataUsuario->getNombre(); ?>"
                                                           placeholder="Ingrese su nombre">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="apellido"
                                                           name="apellido" value="<?= $DataUsuario->getApellido(); ?>"
                                                           placeholder="Ingrese su apellido">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" minlength="6" class="form-control"
                                                           id="telefono" name="telefono"
                                                           value="<?= $DataUsuario->getTelefono(); ?>"
                                                           placeholder="Ingrese su teléfono">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="correo"
                                                           name="correo" value="<?= $DataUsuario->getCorreo(); ?>"
                                                           placeholder="Ingrese su correo">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="usuario" class="col-sm-2 col-form-label"> Nombre de Usuario</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $DataUsuario->getUsuario(); ?>" placeholder="Ingrese su usuario para iniciar sesión">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="contrasena" class="col-sm-2 col-form-label">Contraseña</label>
                                                <div class="col-sm-8">
                                                    <input type="password" class="form-control" id="contrasena" name="contrasena" value="" placeholder="Ingrese su contraseña para iniciar sesión">
                                                </div>
                                            </div>
                                            <?php if ($_SESSION['UserInSession']['rol'] !== "Administrador"){ ?>
                                                <div class="form-group row">
                                                    <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                                    <div class="col-sm-8">
                                                        <select required id="rol" name="rol" class="custom-select">
                                                            <option <?= ($DataUsuario->getRol() == "Administrador") ? "selected" : ""; ?> value="Administrador">Administrador</option>
                                                            <option <?= ($DataUsuario->getRol() == "Auxiliar") ? "selected" : ""; ?> value="Auxiliar">Auxiliar</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group row">
                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                <div class="col-sm-8">
                                                    <select required id="estado" name="estado" class="custom-select">
                                                        <option <?= ($DataUsuario->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                        <option <?= ($DataUsuario->getEstado() == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <hr>
                                            <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn btn-success">Enviar</button>
                                            <a href="index.php" role="button" class="btn bg-success float-right">Cancelar</a>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
<script>
    );
</script>
</body>
</html>