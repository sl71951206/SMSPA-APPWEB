<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE || !isset($_SESSION['useradmin'])) {
    header('Location: index.php');
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
    <script src="assets/js/employees.js"></script>
    <?php include_once('assets/includes/dashboard.php'); ?>
    <!-- Modal Crear -->
    <div class="modal fade" id="crearModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Registrar Nuevo Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Ingrese nombres" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Ingrese apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="correo" placeholder="Ingrese correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" placeholder="Ingrese teléfono" required>
                        </div>
                        <div class="mb-3">
                            <label for="urlImagen" class="form-label">Url Imagen:</label>
                            <input type="text" class="form-control" id="urlImagen" placeholder="Ingrese la URL de la imagen" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select class="form-select" id="estado">
                                <option value="true">Activo</option>
                                <option value="false">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" placeholder="Ingrese una descripción" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Registrar</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Ingrese nombres" required> 
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Ingrese apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="correo" placeholder="Ingrese correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" placeholder="Ingrese teléfono" required>
                        </div>
                        <div class="mb-3">
                            <label for="urlImagen" class="form-label">Url Imagen:</label>
                            <input type="text" class="form-control" id="urlImagen" placeholder="Ingrese la URL de la imagen" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select class="form-select" id="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea class="form-control" id="descripcion" placeholder="Ingrese una descripción" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <section id="Employees" style="margin-bottom: 35px;">
        <div class="container">
            <h2 class="text-center mt-5"><u><i class="fa fa-users"></i> Mantenimiento de Empleados:</u></h2>
            <div class="form-group mt-3">
                <form class="inline-form" action="" method="POST">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearModal">
                        <i class="fa fa-plus-square"></i> Nuevo Empleado
                    </button>
                    <button type="submit" name="accion" value="ExportarPDF" class="btn btn-outline-danger"><i class="fa fa-file-pdf-o"></i> Exportar En Formato PDF</button>
                </form>
            </div>

            <table id="employeeTable" class="table table-hover table-bordered mt-1">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center">Url Imagen</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </section>
</body>

</html>