<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/TalentosController.php");

use App\Controllers\UsuariosController;
use App\Controllers\TalentosController;
use App\Models\Talentos;
use App\Models\GeneralFunctions;

$nameModel = "Talento";
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
                        <h1>Información del <?= $nameModel ?> Humano</h1>
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
                                $DataTalentoHumano = TalentosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataTalentoHumano Talentos */
                                if (!empty($DataTalentoHumano)) {
                                    ?>
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="far fa-file-alt mr-1"></i> &nbsp; Ver
                                            Información de <?= $DataTalentoHumano->getNombres();?> <?= $DataTalentoHumano->getApellidos();?></h3>
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

                                        <p>
                                            <strong><i class="fas fa-book mr-1"></i> Nombre y
                                                Apellido</strong>
                                        <p class="text-muted">
                                            <?= $DataTalentoHumano->getNombres() . " " . $DataTalentoHumano->getApellidos() ?>
                                        </p>
                                        <hr>
                                        <strong><i class="fas fa-user mr-1"></i> Documento</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getTipoDocumento() . ": " . $DataTalentoHumano->getDocumento() ?></p>
                                        <hr>

                                        <strong><i class="far fa-user mr-1"></i> Estado Civil</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getEstadoCivil(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-phone mr-1"></i> Telefono</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getTelefono(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="far fa-user mr-1"></i> Dirección</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getDireccion(); ?></p>
                                        <hr>

                                        <hr>
                                        <strong><i class="fas fa-envelope"></i> Correo</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getCorreo(); ?></p>
                                        <hr>

                                        <strong><i class="fas fa-cog mr-1"></i> Estado</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getEstado(); ?></p>
                                        </p>

                                        <hr>
                                        <strong><i class="fas fa-user mr-1"></i> Usuario</strong>
                                        <p class="text-muted"><?= $DataTalentoHumano->getUsuario()->getNombre(); ?></p>
                                        </p>


                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-auto mr-auto">
                                                <a role="button" href="index.php" class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-tasks"></i> Gestionar <?= $pluralModel ?> Humanos
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a role="button" href="create.php" class="btn btn-success float-right"
                                                   style="margin-right: 5px;">
                                                    <i class="fas fa-plus"></i> Crear <?= $nameModel ?> Humano
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
