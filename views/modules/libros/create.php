<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Models\GeneralFunctions;
use App\Controllers\UsuariosController;
use App\Models\Libros;
use App\Controllers\LibrosController;

$nameModel ="Libro";
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
                        <h1> Registrar <?= $nameModel ?></h1>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Información del <?= $nameModel ?></h3>
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
                                            <?= UsuariosController::selectUsuario(
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
                                        <label for="disposicionFinal" class="col-sm-2 col-form-label">
                                            Disposicion Final</label>
                                        <div class="col-sm-8">
                                            <select id="disposicionFinal" name="disposicionFinal" class="custom-select">
                                                <option <?= (!empty($frmSession['disposicionFinal']) && $frmSession['disposicionFinal'] == "C.T") ? "selected" : ""; ?> value="C.T">Conservación Total</option>
                                                <option <?= (!empty($frmSession['disposicionFinal']) && $frmSession['disposicionFinal'] == "E") ? "selected" : ""; ?> value="E">Eliminación</option>
                                                <option <?= (!empty($frmSession['disposicionFinal']) && $frmSession['disposicionFinal'] == "P") ? "selected" : ""; ?> value="P">Permanente</option>
                                                <option <?= (!empty($frmSession['disposicionFinal']) && $frmSession['disposicionFinal'] == "MD") ? "selected" : ""; ?> value="MD">Microfirmación Diligitación</option>
                                                <option <?= (!empty($frmSession['disposicionFinal']) && $frmSession['disposicionFinal'] == "S") ? "selected" : ""; ?> value="S">Selección</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="retencion" class="col-sm-2 col-form-label">
                                            Retencion</label>
                                        <div class="col-sm-8">
                                            <select id="retencion" name="retencion" class="custom-select">
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "0") ? "selected" : ""; ?> value="0">0</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "2") ? "selected" : ""; ?> value="2">2</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "5") ? "selected" : ""; ?> value="5">5</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "10") ? "selected" : ""; ?> value="10">10</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "15") ? "selected" : ""; ?> value="15">15</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "20") ? "selected" : ""; ?> value="20">20</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "25") ? "selected" : ""; ?> value="25">25</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "30") ? "selected" : ""; ?> value="30">30</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "35") ? "selected" : ""; ?> value="35">35</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "40") ? "selected" : ""; ?> value="40">40</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "45") ? "selected" : ""; ?> value="45">45</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "50") ? "selected" : ""; ?> value="50">50</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "55") ? "selected" : ""; ?> value="55">55</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "60") ? "selected" : ""; ?> value="60">60</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "65") ? "selected" : ""; ?> value="65">65</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "70") ? "selected" : ""; ?> value="70">70</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "75") ? "selected" : ""; ?> value="75">75</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "80") ? "selected" : ""; ?> value="80">80</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "85") ? "selected" : ""; ?> value="85">85</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "90") ? "selected" : ""; ?> value="90">90</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "95") ? "selected" : ""; ?> value="95">95</option>
                                                <option <?= (!empty($frmSession['retencion']) && $frmSession['retencion'] == "100") ? "selected" : ""; ?> value="100">100</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nivelLibro" class="col-sm-2 col-form-label">Nivel del estante del Libro</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="nivelLibro" name="nivelLibro"
                                                    placeholder="Ingrese el nivel del libro" value="<?= $frmSession['nivelLibro'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="estanteLibro" class="col-sm-2 col-form-label">Número del estante del Libro</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="estanteLibro" name="estanteLibro"
                                                    placeholder="Ingrese el estante del libro" value="<?= $frmSession['estanteLibro'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="cantidad" name="cantidad"
                                                   placeholder="Ingrese la cantidad" value="<?= $frmSession['cantidad'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numBoletin" class="col-sm-2 col-form-label">Número de Boletines</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="numBoletin" name="numBoletin"
                                                   placeholder="Ingrese el número de boletin" value="<?= $frmSession['numBoletin'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="numComprobante" class="col-sm-2 col-form-label">Número de Comprobantes</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="numComprobante" name="numComprobante"
                                                   placeholder="Ingrese el número del comprobante" value="<?= $frmSession['numComprobante'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="mes" class="col-sm-2 col-form-label">Mes</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="mes" name="mes"
                                                   placeholder="Ingrese el mes" value="<?= $frmSession['mes'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="agenda" class="col-sm-2 col-form-label">Año</label>
                                        <div class="col-sm-8">
                                            <input  type="text" class="form-control" id="agenda" name="agenda"
                                                   placeholder="Ingrese el año" value="<?= $frmSession['agenda'] ?? '' ?>">
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
