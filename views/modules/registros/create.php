<?php

require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\RegistrosController;
use App\Controllers\UsuariosController;
use App\Models\GeneralFunctions;
use App\Enums\Estado;
use App\Models\Registros;


$nameModel = "Registro";
$nameForm = 'frmCreate'.$nameModel;
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION[$nameForm] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Crear <?= $nameModel ?></title>
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
                        <h1> Registrar Historial Laboral</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Crear</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-white">




                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Información de la Historial Laboral</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="create.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <form class="form-horizontal" method="post" id="<?= $nameForm ?>" name="<?= $nameForm ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=create">

                                    <div class="form-group row">
                                        <label for="usuarios_id" class="col-sm-2 col-form-label">Usuario </label>
                                        <div class="col-sm-8">
                                            <?=
                                            UsuariosController::selectUsuario(
                                                array(
                                                    'id' => 'usuarios_id',
                                                    'name' => 'usuarios_id',
                                                    'class' => 'form-control select2bs4 select2-info',
                                                    'where' => "estado = 'Activo'"
                                                )
                                            )
                                            ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="numeroGaveta" class="col-sm-2 col-form-label">Número de la Gaveta</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numeroGaveta" name="numeroGaveta"
                                                    placeholder="Ingrese el número del gaveta" value="<?= $frmSession['numeroGaveta'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="numeroCarpetas" class="col-sm-2 col-form-label">Número de Carpetas</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numeroCarpetas" name="numeroCarpetas"
                                                    placeholder="Ingrese el número de carpetas" value="<?= $frmSession['numeroCarpetas'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="numeroFolios" class="col-sm-2 col-form-label">Número de Folios</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numeroFolios" name="numeroFolios"
                                                    placeholder="Ingrese el número de folios" value="<?= $frmSession['numeroFolios'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numeroArchivador" class="col-sm-2 col-form-label">Número del Archivador</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numeroArchivador" name="numeroArchivador"
                                                    placeholder="Ingrese el número del Archivador" value="<?= $frmSession['numeroArchivador'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tipoVinculacion" class="col-sm-2 col-form-label">Tipo de Vinculación</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="tipoVinculacion" name="tipoVinculacion"
                                                   placeholder="Ingrese el tipo de Vinculación" value="<?= $frmSession['tipoVinculacion'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="documento" class="col-sm-2 col-form-label">Documento de Identificación</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="documento" name="documento"
                                                   placeholder="Ingrese el documento de Identificación" value="<?= $frmSession['documento'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="nombre" name="nombre"
                                                   placeholder="Ingrese el nombre" value="<?= $frmSession['nombre'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="apellido" name="apellido"
                                                   placeholder="Ingrese el apellido" value="<?= $frmSession['apellido'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cargo" class="col-sm-2 col-form-label">Cargo</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="cargo" name="cargo" rows="4"
                                                              placeholder="Ingrese cargo"><?= $frmSession['cargo'] ?? '' ?></textarea>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-8">
                                            <select required id="estado" name="estado" class="custom-select">
                                                <option <?= (!empty($frmSession['estado']) && $frmSession['estado'] == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                <option <?= (!empty($frmSession['estado']) && $frmSession['estado'] == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
                                            </select>
                                        </div>
                                    </div>


                                        <hr>
                                        <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn btn-success">Enviar</button>
                                        <a href="index.php" role="button" class="btn btn-success float-right">Cancelar</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
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
</body>
</html>
