<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/ArchiverosController.php");

use App\Controllers\IngresosController;
use App\Controllers\ArchiverosController;
use App\Models\GeneralFunctions;
use App\Models\Archiveros;

$nameModel = "Archivero";
$pluralModel = $nameModel . 's';
$frmSession = $_SESSION['frm' . $pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Datos del <?= $nameModel ?></title>
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
                        <h1>Información del archivero de Boletín</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                        href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Boletines</a></li>
                            <li class="breadcrumb-item active">Ver</li>
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
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) {
                            $DataArchivero = ArchiverosController::searchForID(["id" => $_GET["id"]]);
                            /* @var $DataArchivero Archiveros */
                            if (!empty($DataArchivero)) {
                            ?>
                            <div class="card-header">
                                <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> &nbsp; Ver Información
                                    de <?= $DataArchivero->getIngresos()->getNombreBeneficiario(); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="show.php" data-source-selector="#card-refresh-content"
                                            data-load-on-init="false"><i class="fas fa-sync-alt"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"
                                            data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-10">

                                        <hr>

                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i>Número de Boletin</strong>
                                        <p class="text-muted"><?= $DataArchivero->getNumBoletin(); ?></p>
                                        <hr>
                                        <hr>

                                        <strong><i class="fas fa-user mr-1"></i>Beneficiario </strong>
                                        <p class="text-muted"><?= $DataArchivero->getIngresos()->getNombreBeneficiario(); ?></p>
                                        <hr>
                                        <hr>

                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i>Número de Recibo</strong>
                                        <p class="text-muted"><?= $DataArchivero->getNumRecibo(); ?></p>
                                        <hr>
                                        <hr>

                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de Folios  </strong>
                                        <p class="text-muted"><?= $DataArchivero->getNumFolios(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número del Estante </strong>
                                        <p class="text-muted"><?= $DataArchivero->getNumEstante(); ?></p>
                                        <hr>
                                        <p>
                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Nivel  del Estante </strong>
                                        <p
                                                class="text-muted"><?= $DataArchivero->getNivelEstante();?></p>
                                        <p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número del Caja </strong>
                                        <p
                                                class="text-muted"><?= $DataArchivero->getNumCaja();?></p>
                                        <p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número  de Carpeta </strong>
                                        <p
                                                class="text-muted"><?= $DataArchivero->getNumCarpeta(); ?></p>
                                        <p>
                                        <hr>


                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto mr-auto">
                                                <a role="button" href="index.php" class="btn bg-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-tasks"></i> Gestionar Ingresos
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a role="button" href="edit.php?id=<?= $DataArchivero->getId(); ?>"
                                                   class="btn bg-success  float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-edit"></i> Editar Ingreso
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                &times;
                                            </button>
                                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                            No se encontro ningun registro con estos parametros de
                                            busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                        </div>
                                    <?php }
                                    } ?>
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
