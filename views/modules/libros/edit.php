<?php


require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/LibrosController.php");

use App\Controllers\UsuariosController;
use App\Controllers\LibrosController;
use App\Models\GeneralFunctions;
use App\Models\Libros;

$nameModel = "Libro";
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
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del <?= $nameModel ?></h3>
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
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) {
                                $DataLibro = LibrosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataLibro Libros */
                                if (!empty($DataLibro)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataLibro->getId(); ?>"
                                                   hidden required="required" type="text">

                                            <div class="form-group row">
                                                <label for="usuarios_id" class="col-sm-2 col-form-label">Usuario </label>
                                                <div class="col-sm-8">
                                                    <?=
                                                    UsuariosController::selectUsuario(
                                                        array(
                                                            'id' => 'usuarios_id',
                                                            'name' => 'usuarios_id',
                                                            'defaultValue' => (!empty($DataLibro)) ? $DataLibro->getUsuariosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>

                                                <div class="form-group row">
                                                    <label for="estanteLibro" class="col-sm-2 col-form-label"> Número del estante del Libro </label>
                                                    <div class="col-sm-8">
                                                        <input  type="text" class="form-control" id="estanteLibro"
                                                               name="estanteLibro" value="<?= $DataLibro->getEstanteLibro(); ?>"
                                                               placeholder="Ingrese el número del estante del libro">
                                                    </div>
                                                </div>
                                                    <div class="form-group row">
                                                        <label for="nivelLibro" class="col-sm-2 col-form-label"> Número del nivel del Libro</label>
                                                        <div class="col-sm-8">
                                                            <input  type="text" class="form-control" id="Fecha"
                                                                   name="nivelLibro" value="<?= $DataLibro->getNivelLibro(); ?>"
                                                                   placeholder="Ingrese el número de nivel del libro">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                                        <div class="col-sm-8">
                                                            <input  type="text" class="form-control" id="cantidad"
                                                                   name="cantidad" value="<?= $DataLibro->getCantidad(); ?>"
                                                                   placeholder="Ingrese la cantidad">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="numBoletin" class="col-sm-2 col-form-label">Número del Boletines</label>
                                                        <div class="col-sm-8">
                                                            <input  type="text" class="form-control" id="numBoletin"
                                                                   name="numBoletin" value="<?= $DataLibro->getNumBoletin(); ?>"
                                                                   placeholder="Ingrese el número  del boletín">
                                                       </div>
                                                    </div>

                                                        <div class="form-group row">
                                                            <label for="numComprobante" class="col-sm-2 col-form-label">Número del Comprobantes</label>
                                                            <div class="col-sm-8">
                                                                <input  type="text" class="form-control" id="numComprobante"
                                                                       name="numComprobante" value="<?= $DataLibro->getNumComprobante(); ?>"
                                                                       placeholder="Ingrese el número del comprobante">
                                                            </div>
                                                        </div>


                                                        <div class="form-group row">
                                                            <label for="mes" class="col-sm-2 col-form-label">Mes</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="mes"
                                                                       name="mes" value="<?= $DataLibro->getMes(); ?>"
                                                                       placeholder="Ingrese el mes">
                                                            </div>
                                                        </div>


                                                <div class="form-group row">
                                                    <label for="agenda" class="col-sm-2 col-form-label">Año</label>
                                                    <div class="col-sm-8">
                                                        <input  type="text" class="form-control" id="agenda"
                                                               name="agenda" value="<?= $DataLibro->getAgenda(); ?>"
                                                               placeholder="Ingrese el año">
                                                    </div>
                                                </div>

                                            <div class="form-group row">
                                                <label for="retencion" class="col-sm-2 col-form-label">
                                                    retencion</label>
                                                <div class="col-sm-8">
                                                    <select id="retencion" name="retencion"
                                                            class="custom-select">
                                                        <option <?= ($DataLibro->getRetencion() == "0") ? "selected" : ""; ?>
                                                                value="0">0
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "2") ? "selected" : ""; ?>
                                                                value="2">2
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "5") ? "selected" : ""; ?>
                                                                value="5">5
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "10") ? "selected" : ""; ?>
                                                                value="10">10
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "15") ? "selected" : ""; ?>
                                                                value="15">15
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "20") ? "selected" : ""; ?>
                                                                value="20">20
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "25") ? "selected" : ""; ?>
                                                                value="25">25
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "30") ? "selected" : ""; ?>
                                                                value="30">30
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "35") ? "selected" : ""; ?>
                                                                value="35">35
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "40") ? "selected" : ""; ?>
                                                                value="40">40
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "45") ? "selected" : ""; ?>
                                                                value="45">45
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "50") ? "selected" : ""; ?>
                                                                value="50">50
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "55") ? "selected" : ""; ?>
                                                                value="55">55
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "60") ? "selected" : ""; ?>
                                                                value="60">60
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "65") ? "selected" : ""; ?>
                                                                value="65">65
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "70") ? "selected" : ""; ?>
                                                                value="70">70
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "75") ? "selected" : ""; ?>
                                                                value="75">75
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "80") ? "selected" : ""; ?>
                                                                value="80">80
                                                        </option> <option <?= ($DataLibro->getRetencion() == "85") ? "selected" : ""; ?>
                                                                value="85">85
                                                        </option>
                                                     <option <?= ($DataLibro->getRetencion() == "90") ? "selected" : ""; ?>
                                                                value="90">90
                                                        </option>
                                                       <option <?= ($DataLibro->getRetencion() == "95") ? "selected" : ""; ?>
                                                                value="95">95
                                                        </option>
                                                        <option <?= ($DataLibro->getRetencion() == "100") ? "selected" : ""; ?>
                                                                value="100">100

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="disposicionFinal" class="col-sm-2 col-form-label">
                                                    disposicionFinal</label>
                                                <div class="col-sm-8">
                                                    <select id="disposicionFinal" name="disposicionFinal"
                                                            class="custom-select">
                                                        <option <?= ($DataLibro->getDisposicionFinal() == "C.T") ? "selected" : ""; ?>
                                                                value="C.T">Conservación Total
                                                        </option>
                                                        <option <?= ($DataLibro->getDisposicionFinal() == "E") ? "selected" : ""; ?>
                                                                value="E">Eliminación
                                                        </option>
                                                        <option <?= ($DataLibro->getDisposicionFinal() == "P") ? "selected" : ""; ?>
                                                                value="P">Permanete
                                                        </option>
                                                        <option <?= ($DataLibro->getDisposicionFinal() == "MD") ? "selected" : ""; ?>
                                                                value="MD">Microfirmación Digitalización
                                                        </option>
                                                        <option <?= ($DataLibro->getDisposicionFinal() == "S") ? "selected" : ""; ?>
                                                                value="S">Selección
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>


                                            <hr>
                                            <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn btn-success">Enviar</button>
                                            <a href="index.php" role="button" class="btn btn-success float-right">Cancelar</a>
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

</body>
</html>

