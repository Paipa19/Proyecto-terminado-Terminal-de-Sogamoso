<?php

require("../../partials/routes.php");
require("../../../app/Controllers/ArchiverosController.php");
require_once("../../partials/check_login.php");

use App\Controllers\IngresosController;
use App\Controllers\ArchiverosController;
use App\Models\GeneralFunctions;
use App\Models\Archiveros;

$nameModel ="Archivero";
$nameForm = 'frmEdit'.$nameModel;
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION[$nameForm] ?? NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE']  ?> | Editar <?= $nameModel ?></title>
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
                        <h1>Editar archivero de Boletín</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Boletines</a></li>
                            <li class="breadcrumb-item active">Editar</li>
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
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del Ingreso</h3>
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
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php

                                $DataArchivero = ArchiverosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataArchivero Archiveros */
                                if (!empty($DataArchivero)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataArchivero->getId(); ?>" hidden
                                                   required="required" type="text">

                                            <div class="form-group row">
                                                <label for="ingresos_id" class="col-sm-2 col-form-label">Beneficiarios </label>
                                                <div class="col-sm-8">
                                                    <?= IngresosController::selectIngreso(
                                                        array(
                                                            'id' => 'ingresos_id',
                                                            'name' => 'ingresos_id',
                                                            'defaultValue' => (!empty($DataArchivero)) ? $DataArchivero->getIngresosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',

                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="numBoletin" class="col-sm-2 col-form-label">Número del Boletin</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numBoletin"
                                                           name="numBoletin" value="<?= $DataArchivero->getNumBoletin(); ?>"
                                                           placeholder="Ingrese el número de boletín">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="numRecibo" class="col-sm-2 col-form-label">Número del Recibo</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numRecibo"
                                                           name="numRecibo" value="<?= $DataArchivero->getNumRecibo(); ?>"
                                                           placeholder="Ingrese el número de recibo">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="numFolios" class="col-sm-2 col-form-label">Número de Folios</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numFolios"
                                                           name="numFolios" value="<?= $DataArchivero->getNumFolios(); ?>"
                                                           placeholder="Ingrese el número de folios">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="numEstante" class="col-sm-2 col-form-label">Número del Estante</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="descripcion"
                                                           name="numEstante" value="<?= $DataArchivero->getNumEstante(); ?>"
                                                           placeholder="Ingrese el número de estante">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="nivelEstante" class="col-sm-2 col-form-label">Nivel de Estante</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nivelEstante"
                                                           name="nivelEstante" value="<?= $DataArchivero->getNivelEstante(); ?>"
                                                           placeholder="Ingrese el nivel del estante">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="numCaja" class="col-sm-2 col-form-label">Número de Caja</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numCaja"
                                                           name="numCaja" value="<?= $DataArchivero->getNumCaja(); ?>"
                                                           placeholder="Ingrese el número de caja">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="numCarpeta" class="col-sm-2 col-form-label">Número de Carpeta</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numCarpeta"
                                                           name="numCarpeta" value="<?= $DataArchivero->getNumCarpeta(); ?>"
                                                           placeholder="Ingrese el número de carpeta">
                                                </div>
                                            </div>



                                            <hr>
                                            <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn bg-success">Enviar</button>
                                            <a href="index.php" role="button" class="btn bg-success float-right">Cancelar</a>
                                        </form>
                                    </div>
                                    <!-- /.card-body -->

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
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
<script>
    );
</script>
</body>
</html>


