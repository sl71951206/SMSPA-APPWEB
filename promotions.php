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
    <script src="assets/js/promotions.js"></script>

    <?php
        if ($_SESSION['useradmin'] === 'user') {
            include_once('assets/includes/dashboard2.php');
        } elseif ($_SESSION['useradmin'] === 'admin') {
            include_once('assets/includes/dashboard.php');
        }
    ?>

    <!-- Modal Crear -->
    <div class="modal fade" id="crearModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Crear Nueva Promoción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" class="form-control" id="titulo" placeholder="Ingrese el título" required maxlength="500">
                        </div>
                        <div class="mb-3">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" class="form-control" id="descuento" placeholder="Ingrese el descuento" required maxlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select class="form-select" id="tipo" required>
                                <option value="PORCENTUAL">Porcentual</option>
                                <option value="EFECTIVO">Efectivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="fechaInicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                            <input type="date" class="form-control" id="fechaFin" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" placeholder="Ingrese la descripción" maxlength="3000"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Crear Promoción</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editarModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Promoción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" class="form-control" id="editTitulo" placeholder="Ingrese el título" required maxlength="500">
                        </div>
                        <div class="mb-3">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" class="form-control" id="editDescuento" placeholder="Ingrese el descuento" required maxlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select class="form-select" id="editTipo" required>
                                <option value="PORCENTUAL">Porcentual</option>
                                <option value="EFECTIVO">Efectivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="editFechaInicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                            <input type="date" class="form-control" id="editFechaFin" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="editDescripcion" placeholder="Ingrese la descripción" maxlength="3000"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Editar Promoción</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <section id="Promociones" style="margin-bottom: 35px;">
        <div class="container">
            <h2 class="text-center mt-5"><u><i class='bx bxs-offer'></i> Mantenimiento de Promociones:</u></h2>
            <div class="form-group mt-3">
                <form class="inline-form" action="" method="POST">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearModal">
                        <i class="fa fa-plus-square"></i> Nueva Promoción
                    </button>
                </form>
            </div>

            <table id="promotionsTable" class="table table-hover table-bordered mt-1">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Título</th>
                        <th class="text-center">Descuento</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Fec. Inicio</th>
                        <th class="text-center">Fec. Fin</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>