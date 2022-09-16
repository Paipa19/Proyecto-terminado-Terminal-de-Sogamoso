<header>
    <nav>

        <input type="checkbox" id="ckbox">
        <label for="ckbox" class="drawer">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </label>



        <ul class="menu-box">


            <div class="drop-down-menu">
                <a href="<?= $baseURL; ?>/views/index.php">
                    <button class="drop-down-button">INICIO</button>
                </a>

            </div>

            <?php if ($_SESSION['UserInSession']['rol'] == "Administrador"){ ?>
            <div class="drop-down-menu">
                <button class="drop-down-button">USUARIOS
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/usuarios/index.php">Gestionar Usuario</a>
                    <a href="<?= $baseURL ?>/views/modules/usuarios/create.php" >Registrar Usuario</a>
                </div>
            </div>
            <?php } ?>


            <div class="drop-down-menu">
                <button class="drop-down-button">BOLETINES
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/archiveros/index.php">Gestionar Archivero Boletin</a>
                    <a href="<?= $baseURL ?>/views/modules/archiveros/create.php">Registrar Archivero Boletin
                        <a href="<?= $baseURL ?>/views/modules/ingresos/index.php">Gestionar Boletin</a>
                        <a href="<?= $baseURL ?>/views/modules/ingresos/create.php">Registrar Boletin</a>

                </div>
            </div>
            <div class="drop-down-menu">
                <button class="drop-down-button">EGRESOS
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/archivos/index.php">Gestionar Archivero Egreso</a>
                    <a href="<?= $baseURL ?>/views/modules/archivos/create.php">Registrar Archivero Egreso</a>
                    <a href="<?= $baseURL ?>/views/modules/egresos/index.php">Gestionar Comprobante Egreso</a>
                    <a href="<?= $baseURL ?>/views/modules/egresos/create.php">Registrar Comprobante Egreso</a>

                </div>
            </div>
            <div class="drop-down-menu">
                <button class="drop-down-button">LIBROS
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/libros/index.php">Gestionar Libro</a>
                    <a href="<?= $baseURL ?>/views/modules/libros/create.php">Registrar Libro</a>
                </div>
            </div>


            <?php if($_SESSION['UserInSession']['rol'] !== 'Auxiliar'){?>
            <div class="drop-down-menu">
                <button class="drop-down-button">TALENTO HUMANO
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/talentos/index.php">Gestionar Talento Humano</a>
                    <a href="<?= $baseURL ?>/views/modules/talentos/create.php">Registrar Talento Humano</a>
                    <a href="<?= $baseURL ?>/views/modules/documentos/index.php">Gestionar Documentos de Identificación</a>
                    <a href="<?= $baseURL ?>/views/modules/documentos/create.php">Registrar Documentos de Identificación</a>
                    <a href="<?= $baseURL ?>/views/modules/empleados/index.php">Gestionar Contratación Laboral</a>
                    <a href="<?= $baseURL ?>/views/modules/empleados/create.php">Registrar Contratación Laboral</a>
                    <a href="<?= $baseURL ?>/views/modules/seguros/index.php">Gestionar Afiliación Laboral</a>
                    <a href="<?= $baseURL ?>/views/modules/seguros/create.php">Registrar Afiliación Laboral</a>
                    <a href="<?= $baseURL ?>/views/modules/integrantes/index.php">Gestionar Familiares del Talento Humano</a>
                    <a href="<?= $baseURL ?>/views/modules/integrantes/create.php">Registrar Familiares del Talento Humano</a>

                </div>
            </div>
            <?php } ?>
            <div class="drop-down-menu">
                <button class="drop-down-button">HISTORIA LABORAL
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="drop-down-menu-content">
                    <a href="<?= $baseURL ?>/views/modules/registros/index.php">Gestionar Historial Laboral</a>
                    <a href="<?= $baseURL ?>/views/modules/registros/create.php">Registrar Historial Laboral</a>
                </div>
            </div>

            <div class="drop-down-menu">
                <a href="<?= $baseURL; ?>/app/Controllers/MainController.php?controller=Usuarios&action=cerrarSession">
                    <button class="drop-down-button">CERRAR SESIÓN</button>
                </a>
            </div>
        </ul>

    </nav>
</header>

</body>
</html>