<?php

require_once("../../../app/Controllers/EgresosController.php");
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\UsuariosController;
use App\Controllers\ContratosController;
use App\Models\GeneralFunctions;
use App\Controllers\EgresosController;

$nameModel = "Egreso";
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
                        <h1>Registrar <?= $nameModel ?></h1>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Información de la <?= $nameModel ?></h3>
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
                                        <label for="numeroComprobante" class="col-sm-2 col-form-label">Número Comprobante</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numeroComprobante" name="numeroComprobante"
                                                   placeholder="Ingrese el número del comprobante" value="<?= $frmSession['numeroComprobante'] ?? '' ?>">
                                        </div>
                                    </div>s
                                    <div class="form-group row">
                                        <label for="fechaComprobante" class="col-sm-2 col-form-label">Fecha Comprobante</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="fechaComprobante" name="fechaComprobante"
                                                   placeholder="Ingrese la fecha comprobante" value="<?= $frmSession['fechaComprobante'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nombreBeneficiario" class="col-sm-2 col-form-label">Nombre del Beneficiario</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="nombreBeneficiario" name="nombreBeneficiario"
                                                   placeholder="Ingrese el nombre del beneficiario" value="<?= $frmSession['nombreBeneficiario'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numeroIdentificacion" class="col-sm-2 col-form-label">Número de Identificación</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numeroIdentificacion" name="numeroIdentificacion"
                                                   placeholder="Ingrese el número de identificación" value="<?= $frmSession['numeroIdentificacion'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="concepto" class="col-sm-2 col-form-label">Concepto</label>
                                        <div class="col-sm-8">
                                                    <textarea class="form-control" id="concepto" name="concepto" rows="4"
                                                              placeholder="Ingrese un concepto"><?= $frmSession['concepto'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="numContrato" class="col-sm-2 col-form-label"> Número Contrato</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numContrato" name="numContrato"
                                                   placeholder="Ingrese el número de contrato" value="<?= $frmSession['numContrato'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fechaContrato" class="col-sm-2 col-form-label">Fecha Contrato</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="fechaContrato" name="fechaContrato"
                                                   placeholder="Ingrese la fecha contrato" value="<?= $frmSession['fechaContrato'] ?? '' ?>">
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
<!--./wrapper -->
<?php require('../../partials/scripts.php'); ?>

</body>
</html>