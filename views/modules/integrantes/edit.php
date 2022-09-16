<?php

require("../../partials/routes.php");
require("../../../app/Controllers/IntegrantesController.php");
require_once("../../partials/check_login.php");

use App\Controllers\TalentosController;
use App\Controllers\IntegrantesController;
use App\Models\GeneralFunctions;
use App\Models\Integrantes;


$nameModel = "Integrante";
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
                        <h1>Editar Familiar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"> Familiares</a></li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del Familiar</h3>
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

                                $Integrante = IntegrantesController::searchForID(["id" => $_GET["id"]]);
                                /* @var $Integrante Integrantes */
                                if (!empty($Integrante)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $Integrante->getId(); ?>" hidden
                                                   required="required" type="text">


                                            <div class="form-group row">
                                                <label for="talentos_id" class="col-sm-2 col-form-label">Talento Humano </label>
                                                <div class="col-sm-8">
                                                    <?=
                                                    TalentosController::selectTalentosHumanos(
                                                        array(
                                                            'id' => 'talentos_id',
                                                            'name' => 'talentos_id',
                                                            'defaultValue' => (!empty($Integrante)) ? $Integrante->getTalentosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>

                                            <div  class="form-group row">
                                                <label for="documentoTalento" class="col-sm-2 col-form-label"> Documento de Identificación </label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="documentoTalento" name="documentoTalento"
                                                           placeholder="Ingrese el documento de identificación de Talento Humano" value="<?=$Integrante->getDocumentoTalento();  ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="tipoDocumento" class="col-sm-2 col-form-label">Tipo
                                                    Documento del familiar</label>
                                                <div class="col-sm-8">
                                                    <select id="tipoDocumento" name="tipoDocumento"
                                                            class="custom-select">
                                                        <option <?= ($Integrante->getTipoDocumento() == "C.C") ? "selected" : ""; ?>
                                                                value="C.C">Cedula de Ciudadania
                                                        </option>
                                                        <option <?= ($Integrante->getTipoDocumento() == "T.I") ? "selected" : ""; ?>
                                                                value="T.I">Tarjeta de Identidad
                                                        </option>
                                                        <option <?= ($Integrante->getTipoDocumento() == "R.C") ? "selected" : ""; ?>
                                                                value="R.C">Registro Civil
                                                        </option>
                                                        <option <?= ($Integrante->getTipoDocumento() == "Pasaporte") ? "selected" : ""; ?>
                                                                value="Pasaporte">Pasaporte
                                                        </option>
                                                        <option <?= ($Integrante->getTipoDocumento() == "C.E") ? "selected" : ""; ?>
                                                                value="C.E">Cedula de Extranjeria
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div  class="form-group row">
                                                <label for="documentoFamiliar" class="col-sm-2 col-form-label">Número de Documento del familiar</label>
                                                <div class="col-sm-8">
                                                    <input  type="text" class="form-control" id="documentoFamiliar" name="documentoFamiliar"
                                                           placeholder="Ingrese el número de documento del familiar" value="<?=$Integrante->getDocumentoFamiliar();  ?>">
                                                </div>
                                            </div>


                                            <div   class="form-group row">
                                                <label for="nombreFamiliar" class="col-sm-2 col-form-label">Nombre del familiar</label>
                                                <div class="col-sm-8">
                                                    <input  required type="text" class="form-control" id="nombreFamiliar" name="nombreFamiliar"
                                                            placeholder="Ingrese el nombre" value="<?=$Integrante->getNombreFamiliar(); ?>">
                                                </div>
                                            </div>


                                            <div  class="form-group row">
                                                <label for="apellidoFamiliar" class="col-sm-2 col-form-label">Apellido del familiar</label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="apellidoFamiliar" name="apellidoFamiliar"
                                                           placeholder="Ingrese el apellido" value="<?= $Integrante->getApellidoFamiliar();  ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-2 col-form-label">Teléfono del familiar</label>
                                                <div class="col-sm-8">
                                                    <input  type="text" class="form-control" id="telefono"
                                                           name="telefono" value="<?= $Integrante->getTelefono(); ?>"
                                                           placeholder="Ingrese el teléfono">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="parentesco" class="col-sm-2 col-form-label">Parentesco </label>
                                                <div class="col-sm-8">
                                                    <input required type="text" class="form-control" id="parentesco"
                                                           name="parentesco" value="<?= $Integrante->getParentesco(); ?>"
                                                           placeholder="Ingrese el parentesco">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                <div class="col-sm-8">
                                                    <select required id="estado" name="estado" class="custom-select">
                                                        <option <?= ($Integrante->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                        <option <?= ($Integrante->getEstado() == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
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
<script>
    );
</script>
</body>
</html>
