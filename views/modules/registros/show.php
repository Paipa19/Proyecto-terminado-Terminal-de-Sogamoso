<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/RegistrosController.php");

use App\Controllers\RegistrosController;
use App\Models\GeneralFunctions;
use App\Models\Registros;

$nameModel = "Registro";
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
                        <h1>Información del Historial Laboral</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
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
                            $DataHistoriaLaboral = RegistrosController::searchForID(["id" => $_GET["id"]]);
                            /* @var $DataHistoriaLaboral Registros */
                            if (!empty($DataHistoriaLaboral)) {
                            ?>
                            <div class="card-header">
                                <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> &nbsp; Ver Información
                                    de <?= $DataHistoriaLaboral->getNombre() ?></h3>
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
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de la Gaveta</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getNumeroGaveta() ?></p>
                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de carpetas</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getNumeroCarpetas() ?></p>
                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Número de Folios</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getNumeroFolios() ?></p>
                                        <hr>
                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i>Número del Archivador </strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getNumeroArchivador() ?></p>
                                        <hr>

                                        <strong><i class="fas fa-user mr-1"></i> Tipo de Vinculación</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getTipoVinculacion() ?></p>
                                        <hr>
                                        <strong><i class="fas fa-user mr-1"></i> Nombre y Apellido</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getNombre() ?> <?= $DataHistoriaLaboral->getApellido() ?></p>
                                        <hr>

                                        <strong><i class="fas fa-sort-numeric-down mr-1"></i> Documento</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getDocumento() ?></p>
                                        <hr>

                                        <hr>

                                        <strong><i class="fas fa-cog mr-1"></i> Estado</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getEstado() ?></p>
                                        <hr>

                                        <strong><i class="fas fa-cog mr-1"></i>  Cargo </strong>
                                        <p class="text-muted"> <?= $DataHistoriaLaboral->getCargo() ?></p>

                                        <hr>

                                        <strong><i class="fas fa-user mr-1"></i> Usuario</strong>
                                        <p class="text-muted"><?= $DataHistoriaLaboral->getUsuario()->getNombre(); ?> <?= $DataHistoriaLaboral->getUsuario()->getApellido(); ?></p>
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
                                                <a role="button" href="edit.php?id=<?= $DataHistoriaLaboral->getId(); ?>"
                                                   class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-edit"></i> Editar <?= $nameModel ?>
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
