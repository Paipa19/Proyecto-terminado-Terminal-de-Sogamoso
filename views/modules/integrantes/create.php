<?php

require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\TalentosController;
use App\Controllers\IntegrantesController;
use App\Models\GeneralFunctions;
use App\Enums\Estado;
use App\Models\Integrantes;


$nameModel = "Integrante";
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
                        <h1>Registrar Familiar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Familiares</a></li>
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
                                <h3 class="card-title"><i class="fas fa-box"></i> &nbsp; Informaci??n Familiar</h3>
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
                                        <label for="talentos_id" class="col-sm-2 col-form-label">Talento Humano</label>
                                        <div class="col-sm-8">
                                            <?= TalentosController::selectTalentosHumanos(
                                                array (
                                                    'id' => 'talentos_id',
                                                    'name' => 'talentos_id',
                                                    'defaultValue' => !empty($_SESSION['id']) ? $_SESSION['id']->getId() : '',
                                                    'class' => 'form-control select2bs4 select2-info',
                                                    'where' => "estado = 'Activo'"
                                                )
                                            )
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="documentoTalento" class="col-sm-2 col-form-label">Documento de Identificaci??n </label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="documentoTalento" name="documentoTalento"
                                                   placeholder="Ingrese el n??mero de documento de identificaci??n de Talento Humano" value="<?= $frmSession['documentoTalento'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tipoDocumento" class="col-sm-2 col-form-label">
                                            Tipo Documento del familiar</label>
                                        <div class="col-sm-8">
                                            <select id="tipoDocumento" name="tipoDocumento" class="custom-select">
                                                <option <?= (!empty($frmSession['tipoDocumento']) && $frmSession['tipoDocumento'] == "C.C") ? "selected" : ""; ?> value="C.C">Cedula de Ciudadania</option>
                                                <option <?= (!empty($frmSession['tipoDocumento']) && $frmSession['tipoDocumento'] == "C.E") ? "selected" : ""; ?> value="C.E">Cedula de Extranjeria</option>
                                                <option <?= (!empty($frmSession['tipoDocumento']) && $frmSession['tipoDocumento'] == "T.I") ? "selected" : ""; ?> value="T.I">Tarjeta de Identidad</option>
                                                <option <?= (!empty($frmSession['tipoDocumento']) && $frmSession['tipoDocumento'] == "R.C") ? "selected" : ""; ?> value="R.C">Registro Civil</option>
                                                <option <?= (!empty($frmSession['tipoDocumento']) && $frmSession['tipoDocumento'] == "Pasaporte") ? "selected" : ""; ?> value="Pasaporte">Pasaporte</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="documentoFamiliar" class="col-sm-2 col-form-label">Documento del familiar</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="documentoFamiliar" name="documentoFamiliar"
                                                   placeholder="Ingrese el n??mero de documento del familiar" value="<?= $frmSession['documentoFamiliar'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nombreFamiliar" class="col-sm-2 col-form-label">Nombre del familiar</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="nombreFamiliar" name="nombreFamiliar"
                                                   placeholder="Ingrese el nombre" value="<?= $frmSession['nombreFamiliar'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="apellidoFamiliar" class="col-sm-2 col-form-label">Apellido del familiar</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id=apellidoFamiliar" name="apellidoFamiliar"
                                                   placeholder="Ingrese el apellido" value="<?= $frmSession['apellidoFamiliar'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label">Tel??fono del familiar</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="telefono" name="telefono"
                                                   placeholder="Ingrese el tel??fono" value="<?= $frmSession['telefono'] ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="parentesco" class="col-sm-2 col-form-label">Parentesco</label>
                                        <div class="col-sm-8">
                                            <input required type="text" class="form-control" id="parentesco" name="parentesco"
                                                   placeholder="Ingrese el parentesco" value="<?= $frmSession['parentesco'] ?? '' ?>">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-8">
                                            <select required id="estado" name="estado" class="custom-select">
                                                <option <?= (!empty($frmSession['estado']) && $frmSession['estado'] == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                <option <?= (!empty($frmSession['estado']) && $frmSession['estado'] == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
                                            </select>
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