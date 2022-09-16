<?php
require_once("../../../app/Controllers/LibrosController.php");
require_once("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Models\GeneralFunctions;
use App\Models\Libros;
use App\Controllers\LibrosController;

$nameModel = "Libro";
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION['frm'.$pluralModel] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>

    <title><?= $_ENV['TITLE_SITE'] ?> | Gestión de <?= $pluralModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-responsive/css/responsive.bootstrap4.css">
    <link rel="stylesheet" href="<?= $adminlteURL ?>/plugins/datatables-buttons/css/buttons.bootstrap4.css">
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require_once("../../partials/navbar_customization.php"); ?>

    <?php require_once("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> <strong> Libros </strong> </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item active"><?= $pluralModel ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Default box -->
                        <div class="card card-white">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-boxes"></i> &nbsp; Gestionar <?= $pluralModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="card-refresh"
                                            data-source="index.php" data-source-selector="#card-refresh-content"
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
                                    <div class="col-auto mr-auto"></div>
                                    <div class="col-auto">
                                        <a role="button" href="create.php" class="btn btn-success float-right"
                                           style="margin-right: 5px;">
                                            <i class="fas fa-plus"></i> Registrar <?= $nameModel ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                        <table id="Table" class="records_list table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Disposición Final</th>
                                                <th>Retención</th>
                                                <th>Nivel del Libro</th>
                                                <th>Estante del Libro</th>
                                                <th>Cantidad</th>
                                                <th>Número de Boletines</th>
                                                <th>Número de Comprobantes</th>
                                                <th>Mes</th>
                                                <th>Año</th>
                                                <th>Usuario</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $arrLibros = LibrosController::getAll();
                                            /* @var $arrLibros Libros[] */
                                            foreach ($arrLibros as $libro) {
                                                ?>
                                                <tr>
                                                    <td><?= $libro->getId(); ?></td>
                                                    <td><?= $libro->getDisposicionFinal(); ?></td>
                                                    <td><?= $libro->getRetencion(); ?></td>
                                                    <td><?= $libro->getNivelLibro(); ?></td>
                                                    <td><?= $libro->getEstanteLibro(); ?></td>
                                                    <td><?= $libro->getCantidad(); ?></td>
                                                    <td><?= $libro->getNumBoletin(); ?></td>
                                                    <td><?= $libro->getNumComprobante(); ?></td>
                                                    <td><?= $libro->getMes(); ?></td>
                                                    <td><?= $libro->getAgenda(); ?></td>
                                                    <td><?= $libro->getUsuario()->getNombre(); ?> <?= $libro->getUsuario()->getApellido(); ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?= $libro->getId(); ?>"
                                                           type="button" data-toggle="tooltip" title="Actualizar"
                                                           class="btn docs-tooltip bg-navy btn-xs"><i
                                                                    class="fa fa-edit"></i></a>
                                                        <a href="show.php?id=<?= $libro->getId(); ?>"
                                                           type="button" data-toggle="tooltip" title="Ver"
                                                           class="btn docs-tooltip btn-warning btn-xs"><i
                                                                    class="fa fa-eye"></i></a>

                                                    </td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Disposición Final</th>
                                                <th>Retención</th>
                                                <th>Nivel del Libro</th>
                                                <th>Estante del Libro</th>
                                                <th>Cantidad</th>
                                                <th>Número de Boletines</th>
                                                <th>Número de Comprobantes</th>
                                                <th>Mes</th>
                                                <th>Año</th>
                                                <th>Usuario</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
                            <!-- /.card-footer-->
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
<!-- Scripts requeridos para las datatables -->
<?php require('../../partials/datatables_scripts.php'); ?>

<script src="<?= $baseURL ?>/views/public/js/filtroBusqueda.min.js"></script>


</body>
</html>

