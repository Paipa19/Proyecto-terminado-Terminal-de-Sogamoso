<?php

require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\TalentosController;
use App\Controllers\EmpleadosController;
use App\Models\GeneralFunctions;
use App\Enums\Estado;
use App\Models\Empleados;

$nameModel = "Empleado";
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
                        <h1>Registrar Contratación </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Contrataciónes</a></li>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Información de la Contratación</h3>
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
                                        <label for="talentos_id" class="col-sm-2 col-form-label">Talento Humano</label>
                                        <div class="col-sm-8">
                                            <?= TalentosController::selectTalentosHumanos(
                                                array(
                                                    'id' => 'talentos_id',
                                                    'name' => 'talentos_id',
                                                    'class' => 'form-control select2bs4 select2-info',
                                                    'where' => "estado = 'Activo'"
                                                )
                                            )
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tipoContrato" class="col-sm-2 col-form-label">Tipo Contrato</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="tipoContrato" name="tipoContrato"
                                                   placeholder="Ingrese el tipo de contrato" value="<?= $frmSession['tipoContrato'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="documento" class="col-sm-2 col-form-label">Documento de Identificación</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="documento" name="documento"
                                                   placeholder="Ingrese el documento de identificación de Talento Humano" value="<?= $frmSession['documento'] ?? '' ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="numeroContrato" class="col-sm-2 col-form-label">Número del Contrato</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numeroContrato" name="numeroContrato"
                                                   placeholder="Ingrese el número del contrato" value="<?= $frmSession['numeroContrato'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inicioContrato" class="col-sm-2 col-form-label">Fecha de inicio del Contrato</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="inicioContrato" name="inicioContrato"
                                                    placeholder="Ingrese la fecha inicio de contrato" value="<?= $frmSession['inicioContrato'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="finContrato" class="col-sm-2 col-form-label">Fecha de Fin del Contrato</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="finContrato" name="finContrato"
                                                    placeholder="Ingrese la fecha fin del contrato" value="<?= $frmSession['finContrato'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cargo" class="col-sm-2 col-form-label">Cargo</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="cargo" name="cargo"
                                                   placeholder="Ingrese el cargo" value="<?= $frmSession['cargo'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="prorroga1" class="col-sm-2 col-form-label">Prorroga 1</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="prorroga1" name="prorroga1" rows="4"
                                                              placeholder="Ingrese la primera prórroga "><?= $frmSession['prorroga1'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="prorroga2" class="col-sm-2 col-form-label">Prorroga 2</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="prorroga2" name="prorroga2" rows="4"
                                                              placeholder="Ingrese la segunda prórroga "><?= $frmSession['prorroga2'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="prorroga3" class="col-sm-2 col-form-label">Prorroga 3</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="prorroga3" name="prorroga3" rows="4"
                                                              placeholder="Ingrese la tercera prórroga "><?= $frmSession['prorroga3'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="prorroga4" class="col-sm-2 col-form-label">Prorroga 4</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="prorroga4" name="prorroga4" rows="4"
                                                              placeholder="Ingrese la cuarta prórroga "><?= $frmSession['prorroga4'] ?? '' ?></textarea>
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
