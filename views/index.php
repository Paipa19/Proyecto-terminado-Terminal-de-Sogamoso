
<?php require("partials/routes.php"); ?>
<?php  require("partials/check_login.php"); ?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Inicio</title>
    <?php require("partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini ">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("partials/navbar_customization.php"); ?>

    <?php require("partials/sliderbar_main_menu.php"); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><strong>Página principal</strong></h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item"><a href="<?=$adminlteURL; ?>/views/index.php"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item active">Inicio</li>

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">
            <div class="user-panel mt-3 d-flex">
                <div class="image align-middle">
                    <img src="<?= $baseURL ?>/views/public/img/folder.png" class="img-responsive elevation-2" alt="User Image">
                </div>
                <div class="d-flex flex-column">
                    <div class="white">
                        <strong>
                            <a style="color:#246879 " href="<?= "$baseURL/views/modules/usuarios/show.php?id=" .$_SESSION['UserInSession']['id']?>" class="d-block">
                                <?= ucfirst($_SESSION['UserInSession']['nombre'])  ?>
                            </a>
                        </strong>
                    </div>
                    <div class="white">
                       <strong>
                           <a  style="color:#246879 " href="#" class="d-block">
                               <?= $_SESSION['UserInSession']['rol'] ?>
                           </a>
                       </strong>

                    </div>
                </div>
            </div>

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-text"><strong></strong> </h4>
                    <h5>Te damos la bienvenida al sistema de la empresa <strong>TERMINAL DE TRANSPORTES DE SOGAMOSO LTDA</strong>, este sistema esta diseñado
                        con el fin de gestionar los diferentes aspectos de Archivo Central y de Talento Humano. </h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fas fa-times"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <center>
                        <img src="<?= $baseURL ?>/views/public/img/terminal.png" class="img-responsive elevation" alt="Imagen principal">
                    </center>

                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                    <h5><h5><strong>Manual de usuario</strong></h5>
                        <p>Explica el funciomiento del software</p>
                        <a href="public/uploadFiles/documents/MANUAL USUARIO.pdf" type="application/pdf" target="_blank"><strong>MANUAL</strong></a></h5>
                </div>
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require ('partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('partials/scripts.php');?>
</body>
</html>