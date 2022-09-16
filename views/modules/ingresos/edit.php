<?php


require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/IngresosController.php");

use App\Controllers\UsuariosController;
use App\Controllers\IngresosController;
use App\Models\GeneralFunctions;
use App\Models\Ingresos;



$nameModel = "Ingreso";
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
                                $DataIngreso = IngresosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataIngreso Ingresos */
                                if (!empty($DataIngreso)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataIngreso->getId(); ?>"
                                                   hidden required="required" type="text">

                                            <div class="form-group row">
                                                <label for="usuarios_id" class="col-sm-2 col-form-label">Usuario </label>
                                                <div class="col-sm-8">
                                                    <?=
                                                    UsuariosController::selectUsuario(
                                                        array(
                                                            'id' => 'usuarios_id',
                                                            'name' => 'usuarios_id',
                                                            'defaultValue' => (!empty($DataIngreso)) ? $DataIngreso->getUsuariosId() : '',
                                                            'class' => 'form-control select2bs4 select2-info',
                                                            'where' => "estado = 'Activo'"
                                                        )
                                                    )
                                                    ?>
                                                </div>
                                            </div>

                                                <div  class="form-group row">
                                                    <label for="numeroCaja" class="col-sm-2 col-form-label">Número de Caja</label>
                                                    <div class="col-sm-8">
                                                        <input  type="text" class="form-control" id="numeroCaja" name="numeroCaja"
                                                               placeholder="Ingrese el número del Caja" value="<?=$DataIngreso->getNumeroCaja();  ?>">
                                                    </div>
                                                </div>


                                                <div   class="form-group row">
                                                    <label for="numeroBoletin" class="col-sm-2 col-form-label">Número de Boletín</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="numeroBoletin" name="numeroBoletin"
                                                                placeholder="Ingrese el número del boletin" value="<?=$DataIngreso->getNumeroBoletin(); ?>">
                                                    </div>
                                                </div>


                                            <div class="form-group row">
                                                <label for="fecha" class="col-sm-2 col-form-label">Fecha de Boletin</label>
                                                <div class="col-sm-8">
                                                    <input  type="text" class="form-control" id="Fecha"
                                                            name="fecha" value="<?= $DataIngreso->getFecha(); ?>"
                                                            placeholder="Ingrese la fecha">
                                                </div>
                                            </div>


                                            <div   class="form-group row">
                                                <label for="numeroRecibo" class="col-sm-2 col-form-label">Número de Recibo</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="numeroRecibo" name="numeroRecibo"
                                                           placeholder="Ingrese el número del Recibo" value="<?=$DataIngreso->getNumeroRecibo(); ?>">
                                                </div>
                                            </div>




                                                    <div class="form-group row">
                                                                <label for="nombreBeneficiario" class="col-sm-2 col-form-label">Nombre del Beneficiario </label>
                                                                <div class="col-sm-8">
                                                                    <input required type="text" class="form-control" id="nombreBeneficiario"
                                                                           name="nombreBeneficiario" value="<?= $DataIngreso->getNombreBeneficiario(); ?>"
                                                                           placeholder="Ingrese el nombre del Beneficiario">
                                                                </div>
                                                        </div>



                                                            <div class="form-group row">
                                                                   <label for="concepto" class="col-sm-2 col-form-label">Concepto</label>
                                                                <div class="col-sm-8">
                                                                  <textarea class="form-control" id="concepto" name="concepto" rows="4"
                                                                       placeholder="Ingrese un concepto"><?= $DataIngreso->getConcepto(); ?></textarea>
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

