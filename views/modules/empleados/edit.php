<?php

require("../../partials/routes.php");
require("../../../app/Controllers/EmpleadosController.php");
require_once("../../partials/check_login.php");

use App\Controllers\TalentosController;
use App\Controllers\EmpleadosController;
use App\Models\GeneralFunctions;
use App\Models\Empleados;


$nameModel ="Empleado";
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
                        <h1>Editar Contratación</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php">Contrataciones</a></li>
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
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del la Contratación</h3>
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

                                $Empleado = EmpleadosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $Empleado Empleados */
                                if (!empty($Empleado)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $Empleado->getId(); ?>" hidden
                                                   required="required" type="text">
                                                    <div class="form-group row">
                                                        <label for="talentos_id" class="col-sm-2 col-form-label">Talento Humano </label>
                                                        <div class="col-sm-8">
                                                            <?= TalentosController::selectTalentosHumanos(
                                                                array(
                                                                    'id' => 'talentos_id',
                                                                    'name' => 'talentos_id',
                                                                    'defaultValue' => (!empty($Empleado)) ? $Empleado->getTalentosId() : '',
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => ''
                                                                )
                                                            )
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="tipoContrato" class="col-sm-2 col-form-label">Tipo Contrato</label>
                                                        <div class="col-sm-8">
                                                            <input required type="text" class="form-control" id="tipoContrato"
                                                                   name="tipoContrato" value="<?= $Empleado->getTipoContrato(); ?>"
                                                                   placeholder="Ingrese el tipo de contrato">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="documento" class="col-sm-2 col-form-label">Documento de Identificación</label>
                                                        <div class="col-sm-8">
                                                            <input required type="text" class="form-control" id="documento"
                                                                   name="documento" value="<?= $Empleado->getDocumento(); ?>"
                                                                   placeholder="Ingrese el documento de identificación de Talento Humano">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="numeroContrato" class="col-sm-2 col-form-label"> Número del Contrato</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="numeroContrato"
                                                                   name="numeroContrato" value="<?= $Empleado->getNumeroContrato(); ?>"
                                                                   placeholder="Ingrese el número contrato">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inicioContrato" class="col-sm-2 col-form-label">Fecha de Inicio del Contrato</label>
                                                        <div class="col-sm-8">
                                                            <input required type="text" class="form-control" id="inicioContrato"
                                                                   name="inicioContrato" value="<?= $Empleado->getInicioContrato(); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="finContrato" class="col-sm-2 col-form-label">Fecha de Fin del Contrato</label>
                                                        <div class="col-sm-8">
                                                            <input  type="text" class="form-control" id="finContrato"
                                                                   name="finContrato" value="<?= $Empleado->getInicioContrato(); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="cargo" class="col-sm-2 col-form-label">Cargo </label>
                                                        <div class="col-sm-8">
                                                            <input required type="text" class="form-control" id="cargo"
                                                                   name="cargo" value="<?= $Empleado->getCargo(); ?>"
                                                                   placeholder="Ingrese el cargo">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label for="prorroga1" class="col-sm-2 col-form-label">Prórroga 1</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" id="prorroga1" name="prorroga1" rows="4"
                                                                                      placeholder="Ingrese la primera prórroga"><?= $Empleado->getProrroga1();?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="prorroga2" class="col-sm-2 col-form-label">Prórroga 2</label>
                                                        <div class="col-sm-8">
                                                                    <textarea class="form-control" id="prorroga2" name="prorroga2" rows="4"
                                                                              placeholder="Ingrese la segunda prórroga"><?= $Empleado->getProrroga2();?></textarea>
                                                        </div>
                                                    </div>

                                                <div class="form-group row">
                                                    <label for="prorroga3" class="col-sm-2 col-form-label">Prórroga 3</label>
                                                    <div class="col-sm-8">
                                                                        <textarea class="form-control" id="prorroga3" name="prorroga3" rows="4"
                                                                                  placeholder="Ingrese la tercera prórroga"><?= $Empleado->getProrroga3();?></textarea>
                                                    </div>
                                                </div>

                                                    <div class="form-group row">
                                                        <label for="prorroga4" class="col-sm-2 col-form-label">Prórroga 4</label>
                                                        <div class="col-sm-8">
                                                                                <textarea class="form-control" id="prorroga4" name="prorroga4" rows="4"
                                                                                          placeholder="Ingrese la cuarta prórroga"><?= $Empleado->getProrroga3();?></textarea>
                                                        </div>
                                                    </div>

                                            <div class="form-group row">
                                                        <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                        <div class="col-sm-8">
                                                            <select required id="estado" name="estado" class="custom-select">
                                                                <option <?= ($Empleado->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                                <option <?= ($Empleado->getEstado() == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
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


