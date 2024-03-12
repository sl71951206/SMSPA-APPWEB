<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION['useradmin'])) {
    header('Location: index.php');
    exit();
} else if ($_SESSION['useradmin'] === 'user') {
    header('Location: calendar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SM Spa | Admin.</title>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body id="body-pd" style="background-color: #dedede;">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/services.js"></script>
    <?php
        if ($_SESSION['useradmin'] === 'user') {
            include_once('assets/includes/dashboard2.php');
        } elseif ($_SESSION['useradmin'] === 'admin') {
            include_once('assets/includes/dashboard.php');
        }
    ?>
    <!---Modal Crear Servicio -->
    <div class="modal fade" id="crearServicioModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Registrar Nuevo Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombre" required maxlength="200">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" placeholder="Ingrese descripción" maxlength="2000"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración (minutos):</label>
                            <input type="number" class="form-control" id="duracion" placeholder="Ingrese duración" required maxlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="text" class="form-control" id="precio" placeholder="Ingrese precio" required pattern="\d{1,5}\.\d{2}">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría:</label>
                            <input type="text" class="form-control" id="categoria" placeholder="Ingrese categoría" required maxlength="100">
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Servicio -->
    <div class="modal fade" id="editarServicioModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombre" required maxlength="200">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" placeholder="Ingrese descripción" maxlength="2000"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="duracion" class="form-label">Duración (minutos):</label>
                            <input type="number" class="form-control" id="duracion" placeholder="Ingrese duración" required maxlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="text" class="form-control" id="precio" placeholder="Ingrese precio" required pattern="\d{1,5}\.\d{2}">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría:</label>
                            <input type="text" class="form-control" id="categoria" placeholder="Ingrese categoría" required maxlength="100">
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Imagen Servicio -->
    <div class="modal fade" id="imagenServicioModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Imagen del servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <img src="" class="img-fluid" alt="" id="imagen">
                        </div>
                        <div class="mb-3">
                            <label for="nombre_imagen" class="form-label">Nombre de la imagen:</label>
                            <input type="text" class="form-control" id="nombre_imagen" placeholder="Ingrese nombre de la imagen" required maxlength="1000" pattern="[A-Za-z0-9_\-]+\.[A-Za-z0-9_\-]+">
                        </div>
                        <div class="mb-3">
                            <label for="archivo_imagen" class="form-label">Archivo de imagen:</label>
                            <input class="form-control" type="file" id="archivo_imagen" required>
                        </div>
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section id="Services" style="margin-bottom: 35px;">
        <div class="container">
            <h2 class="text-center mt-5"><u><i class='bx bxs-dish'></i> Mantenimiento de Servicios:</u></h2>
            <div class="form-group mt-3">
                <form class="inline-form" action="" method="POST">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                        <i class="fa fa-plus-square"></i> Nuevo Servicio
                    </button>
                    <!--
                    <button type="submit" name="accion" value="ExportarPDF" class="btn btn-outline-danger"><i class="fa fa-file-pdf-o"></i> Exportar En Formato PDF</button>
                    -->
                </form>
            </div>
            <table id="servicesTable" class="table table-hover table-bordered mt-1">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Duración</th>
                        <th class="text-center">Precio</th>
                        <!--<th class="text-center">Url Imagen</th>-->
                        <th class="text-center">Categoría</th>
                        <th class="text-center">Favorito</th>
                        <!--<th class="text-center">Estado</th>-->
                        <th class="text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </section>
    <style>
        .blackstar {
            font-size: 25px;
            color: black !important;
        }
        .estrella {
            font-size: 25px;
        }
        .estrella:hover {
            cursor: pointer;
            transform: scale(1.5);
        }
    </style>
</body>

</html>