<?php

require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\EgresosController;
use App\Controllers\ArchivosController;
use App\Models\GeneralFunctions;
use App\Enums\Estado;
use App\Models\Archivos;

$nameModel = "Archivo";
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
                        <h1>Registrar archivero de Egreso</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Egresos</a></li>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Informaci??n del Egreso</h3>
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
                                        <label for="egresos_id" class="col-sm-2 col-form-label">Beneficiarios </label>
                                        <div class="col-sm-8">
                                            <?=
                                                EgresosController::selectEgreso(
                                                array(
                                                    'id' => 'egresos_id',
                                                    'name' => 'egresos_id',
                                                    'class' => 'form-control select2bs4 select2-info',

                                                )
                                            )
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="numeroIdentificacion" class="col-sm-2 col-form-label">N??mero de Identificaci??n</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numeroIdentificacion" name="numeroIdentificacion"
                                                   placeholder="Ingrese el n??mero del identificaci??n" value="<?= $frmSession['numeroIdentificacion'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numComprobante" class="col-sm-2 col-form-label">N??mero Comprobante</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numComprobante" name="numComprobante"
                                                    placeholder="Ingrese el numero del comprobante" value="<?= $frmSession['numComprobante'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="numFolios" class="col-sm-2 col-form-label">N??mero de Folios</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numFolios" name="numFolios"
                                                   placeholder="Ingrese el n??mero del folios" value="<?= $frmSession['numFolios'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numEstante" class="col-sm-2 col-form-label">N??mero del Estante</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numEstante" name="numEstante"
                                                   placeholder="Ingrese el n??mero del estante" value="<?= $frmSession['numEstante'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nivelEstante" class="col-sm-2 col-form-label">Nivel del Estante</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nivelEstante" name="nivelEstante"
                                                   placeholder="Ingrese el nivel del estante " value="<?= $frmSession['nivelEstante'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numCaja" class="col-sm-2 col-form-label">N??mero de Caja</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numCaja" name="numCaja"
                                                   placeholder="Ingrese el n??mero de caja " value="<?= $frmSession['numCaja'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numCarpeta" class="col-sm-2 col-form-label">N??mero de Carpeta</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numCarpeta" name="numCarpeta"
                                                   placeholder="Ingrese el n??mero de carpeta" value="<?= $frmSession['numCarpeta'] ?? '' ?>">
                                        </div>
                                    </div>




                                        <hr>
                                        <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn btn-success">Enviar</button>
                                        <a href="index.php" role="button" class="btn bg-success float-right">Cancelar</a>
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
