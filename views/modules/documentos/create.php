<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\TalentosController;
use App\Models\GeneralFunctions;


$nameModel = "Documento";
$nameForm = 'frm'.$nameModel; //frmDocumento para que la funcion del envio sea global
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;

/* @var $_SESSION['id'] Documento */
?>
<!DOCTYPE html>
<html lang="es">
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
                        <h1>Registrar <?= $nameModel ?> <?= !empty($_SESSION['id']) ? 'de '.$_SESSION['id']->getNombre() : '' ?></h1>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Información del <?= $nameModel ?></h3>
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
                                <form id="<?=$nameForm?>" name="<?=$nameForm?>" method="post" action="../../../app/Controllers/MainController.php?controller=<?=$pluralModel?>&action=create" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <label for="talentos_id" class="col-sm-2 col-form-label">Talento Humano</label>
                                                <div class="col-sm-8">
                                                    <?= TalentosController::selectTalentosHumanos(
                                                        array (
                                                            'id' => 'talentos_id',
                                                            'name' => 'talentos_id',
                                                            'defaultValue' => !empty($_SESSION['id']) ? $_SESSION['id']->getId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo' or estado = 'Inactiva'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="talentoDocumento" class="col-sm-2 col-form-label">Documento de Identificación</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="talentoDocumento" name="talentoDocumento"
                                                           placeholder="Ingrese el documento de identificación de Talento Humano" value="<?= $frmSession['talentoDocumento'] ?? '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="fechaNacimiento" class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                                                <div class="col-sm-8">
                                                    <input  type="text" class="form-control" id="fechaNacimiento" name="fechaNacimiento"
                                                           placeholder="Ingrese la fecha de nacimiento" value="<?= $frmSession['fechaNacimiento'] ?? '' ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="fechaExpedicion" class="col-sm-2 col-form-label">Fecha de Expedición</label>
                                                <div class="col-sm-8">
                                                    <input  type="text" class="form-control" id="fechaExpedicion" name="fechaExpedicion"
                                                           placeholder="Ingrese la fecha de expedición" value="<?= $frmSession['fechaExpedicion'] ?? '' ?>">
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
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="card">
                                                <div id="card-body" class="card-body">
                                                    <div class="input-group">
                                                        <button id="btn-open-file" type="button" class="btn btn-success">Subir Documento</button>
                                                        <input hidden type="file" id="documento" name="documento">
                                                        <!--Input's de tipo hidden no es posible ser obligatorios-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <input value="Enviar" type="submit" class="btn btn-success">
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
<?php require('../../partials/jquery.php'); ?>
<!-- Custom Js User -->
<script src="<?= $baseURL ?>/views/public/js/main.min.js"></script>

</body>
</html>
