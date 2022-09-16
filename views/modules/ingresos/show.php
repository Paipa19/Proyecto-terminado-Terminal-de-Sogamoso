<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/IngresosController.php");

use App\Controllers\UsuariosController;
use App\Controllers\ArchiverosController;
use App\Controllers\IngresosController;
use App\Models\Ingresos;
use App\Models\GeneralFunctions;

$nameModel = "Ingreso";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Datos de la <?= $nameModel ?></title>
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
                        <h1>Información del <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
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
                                $DataIngreso = IngresosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataIngreso Ingresos */
                                if (!empty($DataIngreso)) {
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> &nbsp; Ver
                                            Información de <?= $DataIngreso->getNombreBeneficiario();?></h3>
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
                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de Caja </strong>
                                        <p class="text-muted"><?= $DataIngreso->getNumeroCaja(); ?></p>


                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de Boletín </strong>
                                        <p class="text-muted"><?= $DataIngreso->getNumeroBoletin(); ?></p>

                                        <hr>
                                        <strong><i class="fas fa-calendar-check mr-1"></i> Fecha </strong>
                                        <p class="text-muted"><?= $DataIngreso->getFecha(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de Becibo </strong>
                                        <p class="text-muted"><?= $DataIngreso->getNumeroRecibo(); ?></p>
                                        <hr>

                                        <strong><i class="fas fa-user-check mr-1"></i> Nombre del Beneficiairo </strong>
                                        <p class="text-muted"><?= $DataIngreso->getNombreBeneficiario(); ?></p>
                                        <hr>

                                        <strong><i class="far fa-user mr-1"></i> Concepto</strong>
                                        <p class="text-muted"><?= $DataIngreso->getConcepto(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-user mr-1"></i> Usuario</strong>
                                        <p class="text-muted"><?= $DataIngreso->getUsuario()->getNombre(); ?> <?= $DataIngreso->getUsuario()->getApellido(); ?></p>
                                        </p>


                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto mr-auto">
                                                <a role="button" href="index.php" class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-tasks"></i> Gestionar <?= $pluralModel ?>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a role="button" href="create.php" class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-plus"></i> Crear <?= $nameModel ?>
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
                    </div>
                </div>
            </div>
            <!-- /.card -->
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
