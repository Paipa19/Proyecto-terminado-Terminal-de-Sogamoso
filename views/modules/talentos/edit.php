<?php


require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/TalentosController.php");

use App\Controllers\UsuariosController;
use App\Controllers\TalentosController;
use App\Models\GeneralFunctions;
use App\Models\Talentos;
use Carbon\Carbon;

$nameModel = "Talento";
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
                        <h1>Editar Talento Humano</h1>
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
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del <?= $nameModel ?> Humano</h3>
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
                                $DataTalentoHumano =  TalentosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataTalentoHumano Talentos */
                                if (!empty($DataTalentoHumano)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataTalentoHumano->getId(); ?>"
                                                   hidden required="required" type="text">

                                            <div class="form-group row">
                                                <label for="usuarios_id" class="col-sm-2 col-form-label">Usuario </label>
                                                <div class="col-sm-8">
                                                    <?=
                                                    UsuariosController::selectUsuario(
                                                        array(
                                                            'id' => 'usuarios_id',
                                                            'name' => 'usuarios_id',
                                                            'defaultValue' => (!empty($DataTalentoHumano)) ? $DataTalentoHumano->getUsuariosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tipoDocumento" class="col-sm-2 col-form-label">Tipo
                                                    Documento</label>
                                                <div class="col-sm-8">
                                                    <select id="tipoDocumento" name="tipoDocumento"
                                                            class="custom-select">
                                                        <option <?= ($DataTalentoHumano->getTipoDocumento() == "C.C") ? "selected" : ""; ?>
                                                                value="C.C">Cedula de Ciudadania
                                                        </option>
                                                        <option <?= ($DataTalentoHumano->getTipoDocumento() == "T.I") ? "selected" : ""; ?>
                                                                value="T.I">Tarjeta de Identidad
                                                        </option>
                                                        <option <?= ($DataTalentoHumano->getTipoDocumento() == "R.C") ? "selected" : ""; ?>
                                                                value="R.C">Registro Civil
                                                        </option>
                                                        <option <?= ($DataTalentoHumano->getTipoDocumento() == "Pasaporte") ? "selected" : ""; ?>
                                                                value="Pasaporte">Pasaporte
                                                        </option>
                                                        <option <?= ($DataTalentoHumano->getTipoDocumento() == "C.E") ? "selected" : ""; ?>
                                                                value="C.E">Cedula de Extranjeria
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                                        <div  class="form-group row">
                                                            <label for="documento" class="col-sm-2 col-form-label"> Documento de Identificación</label>
                                                            <div class="col-sm-8">
                                                                <input required type="text" class="form-control" id="documento" name="documento"
                                                                       placeholder="Ingrese el documento identificación de Talento Humano" value="<?=$DataTalentoHumano->getDocumento();  ?>">
                                                            </div>
                                                        </div>



                                                        <div class="form-group row">
                                                            <label for="nombres" class="col-sm-2 col-form-label">Nombre </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="nombres"
                                                                       name="nombres" value="<?= $DataTalentoHumano->getNombres(); ?>"
                                                                       placeholder="Ingrese el nombre">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="apellidos" class="col-sm-2 col-form-label">Apellido </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="apellidos"
                                                                       name="apellidos" value="<?= $DataTalentoHumano->getApellidos(); ?>"
                                                                       placeholder="Ingrese el apellido">
                                                            </div>
                                                        </div>

                                                         <div class="form-group row">
                                                            <label for="estadoCivil" class="col-sm-2 col-form-label">Estado Civil </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="estadoCivil"
                                                                       name="estadoCivil" value="<?= $DataTalentoHumano->getEstadoCivil(); ?>"
                                                                       placeholder="Ingrese el estado civil">
                                                            </div>
                                                          </div>


                                                        <div class="form-group row">
                                                            <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                                                            <div class="col-sm-8">
                                                                <input  type="text" class="form-control" id="telefono"
                                                                       name="telefono" value="<?= $DataTalentoHumano->getTelefono(); ?>"
                                                                       placeholder="Ingrese el teléfono">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="direccion" class="col-sm-2 col-form-label">Dirección </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="direccion"
                                                                       name="direccion" value="<?= $DataTalentoHumano->getDireccion(); ?>"
                                                                       placeholder="Ingrese la dirección">
                                                            </div>
                                                        </div>

                                                            <div class="form-group row">
                                                                <label for="correo" class="col-sm-2 col-form-label">Correo </label>
                                                                <div class="col-sm-8">
                                                                    <input  type="text" class="form-control" id="correo"
                                                                           name="correo" value="<?= $DataTalentoHumano->getCorreo(); ?>"
                                                                           placeholder="Ingrese el correo">
                                                                </div>
                                                            </div>




                                                     <div class="form-group row">
                                                            <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                            <div class="col-sm-8">
                                                                <select required id="estado" name="estado" class="custom-select">
                                                                    <option <?= ($DataTalentoHumano->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                                    <option <?= ($DataTalentoHumano->getEstado() == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
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

