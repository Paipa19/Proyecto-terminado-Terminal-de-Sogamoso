<?php

require("../../partials/routes.php");
require("../../../app/Controllers/RegistrosController.php");
require_once("../../partials/check_login.php");

use App\Controllers\UsuariosController;
use App\Controllers\RegistrosController;
use App\Models\GeneralFunctions;
use App\Models\Registros;

$nameModel = "Registro";
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
                        <h1>Editar Historial Laboral</h1>
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
                                <h3 class="card-title"><i class="fas fa-user"></i>&nbsp; Información del Historial Laboral</h3>
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

                                $HistoriaLaboral = RegistrosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $HistoriaLaboral Registros */
                                if (!empty($HistoriaLaboral)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $HistoriaLaboral->getId(); ?>" hidden
                                                   required="required" type="text">


                                            <div class="form-group row">
                                                <label for="usuarios_id" class="col-sm-2 col-form-label">Usuario </label>
                                                <div class="col-sm-8">
                                                    <?=
                                                    UsuariosController::selectUsuario(
                                                        array(
                                                            'id' => 'usuarios_id',
                                                            'name' => 'usuarios_id',
                                                            'defaultValue' => (!empty($HistoriaLaboral)) ? $HistoriaLaboral->getUsuariosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="numeroGaveta" class="col-sm-2 col-form-label">Número de la Gaveta</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numeroGaveta"
                                                           name="numeroGaveta" value="<?= $HistoriaLaboral->getNumeroGaveta(); ?>"
                                                           placeholder="Ingrese el Número de la Gaveta">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                        <label for="numeroCarpetas" class="col-sm-2 col-form-label">Número de Carpeta</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="numeroCarpetas"
                                                                   name="numeroCarpetas" value="<?= $HistoriaLaboral->getNumeroCarpetas(); ?>"
                                                                   placeholder="Ingrese el numero Carpetas">
                                                        </div>
                                                    </div>




                                                  <div class="form-group row">
                                                            <label for="numeroFolios" class="col-sm-2 col-form-label">Número de Folios</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="numeroFolios"
                                                                       name="numeroFolios" value="<?= $HistoriaLaboral->getNumeroFolios(); ?>"
                                                                       placeholder="Ingrese el Número de Folios">
                                                            </div>
                                                        </div>

                                                    <div class="form-group row">
                                                        <label for="numeroArchivador" class="col-sm-2 col-form-label">Número del Archivador</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="numeroArchivador"
                                                                   name="numeroArchivador" value="<?= $HistoriaLaboral->getNumeroArchivador(); ?>"
                                                                   placeholder="Ingrese el Número Archivador">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="tipoVinculacion" class="col-sm-2 col-form-label">Tipo de Vinculación</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="tipoVinculacion"
                                                                   name="tipoVinculacion" value="<?= $HistoriaLaboral->getTipoVinculacion(); ?>"
                                                                   placeholder="Ingrese el tipo Vinculación">
                                                        </div>
                                                    </div>

                                                        <div class="form-group row">
                                                            <label for="documento" class="col-sm-2 col-form-label">Documento de Identificación</label>
                                                            <div class="col-sm-8">
                                                                <input required type="text" class="form-control" id="documento"
                                                                       name="documento" value="<?= $HistoriaLaboral->getDocumento(); ?>"
                                                                       placeholder="Ingrese el Documento de Identificación">
                                                            </div>
                                                        </div>




                                                            <div class="form-group row">
                                                                <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                                <div class="col-sm-8">
                                                                    <input required type="text" class="form-control" id="nombre"
                                                                           name="nombre" value="<?= $HistoriaLaboral->getNombre(); ?>"
                                                                           placeholder="Ingrese el nombre">
                                                                </div>
                                                            </div>


                                                            <div class="form-group row">
                                                                <label for="apellido" class="col-sm-2 col-form-label">Apellido</label>
                                                                <div class="col-sm-8">
                                                                    <input required type="text" class="form-control" id="apellido"
                                                                           name="apellido" value="<?= $HistoriaLaboral->getApellido(); ?>"
                                                                           placeholder="Ingrese el apellido">
                                                                </div>
                                                            </div>


                                                        <div class="form-group row">
                                                            <label for="cargo" class="col-sm-2 col-form-label">Cargo</label>
                                                            <div class="col-sm-8">
                                                                                <textarea class="form-control" id="cargo" name="cargo" rows="4"
                                                                                          placeholder="Ingrese cargo"><?= $HistoriaLaboral->getCargo();?></textarea>
                                                            </div>
                                                        </div>



                                                          <div class="form-group row">
                                                                <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                                                <div class="col-sm-8">
                                                                    <select required id="estado" name="estado" class="custom-select">
                                                                        <option <?= ($HistoriaLaboral->getEstado() == "") ? "selected" : ""; ?> value=""></option>
                                                                        <option <?= ($HistoriaLaboral->getEstado() == "Inactiva") ? "selected" : ""; ?> value="Inactiva">Inactiva</option>
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


