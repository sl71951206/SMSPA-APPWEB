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
    <script src="assets/js/history.js"></script>
    <?php include_once('assets/includes/dashboard.php'); ?>
    <!---Modal Crear-->
    <div class="modal fade" id="verDetalleModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Detalle de Reserva:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 19px;font-weight: bold;">Reservación:</p>
                                    <div class="mb-3">
                                        <label for="servicio" class="form-label">Servicio:</label>
                                        <input type="text" class="form-control" id="servicio_nombre" placeholder="Servicio" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="duracion" class="form-label mt-1">Duración:</label>
                                        <input type="text" class="form-control" id="servicio_duracion" placeholder="Duracion" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precio" class="form-label">Precio:</label>
                                        <input type="text" class="form-control" id="servicio_precio" placeholder="Precio" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="fechahora" class="form-label">Fecha - Hora:</label>
                                        <input type="text" class="form-control" id="servicio_fechahora" placeholder="FechaHora" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p style="font-size: 19px;font-weight: bold;">Datos Cliente:</p>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="cliente_nombre" placeholder="Nombre" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label mt-1">Apellidos:</label>
                                        <input type="text" class="form-control" id="cliente_apellidos" placeholder="Apellidos" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo:</label>
                                        <input type="text" class="form-control" id="cliente_correo" placeholder="Correo" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Telefono:</label>
                                        <input type="text" class="form-control" id="cliente_telefono" placeholder="Telefono" disabled>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-3">
                                <!-- Segunda fila con dos columnas -->
                                <div class="col-md-6">
                                    <p style="font-size: 19px;font-weight: bold;">Empleado:</p>
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="empleado_nombre" placeholder="Nombre" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label mt-1">Apellidos:</label>
                                        <input type="text" class="form-control" id="empleado_apellidos" placeholder="Apellidos" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo:</label>
                                        <input type="text" class="form-control" id="empleado_correo" placeholder="Correo" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instalacion" class="form-label">Instalacion Usada:</label>
                                        <input type="text" class="form-control" id="empleado_instalacion" placeholder="Instalacion" disabled>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <p style="font-size: 19px;font-weight: bold;">Promoción:</p>
                                    <div class="mb-3">
                                        <label for="promocion_titulo" class="form-label">Titulo:</label>
                                        <input type="text" class="form-control" id="promocion_titulo" placeholder="Titulo" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label mt-1">Tipo:</label>
                                        <input type="text" class="form-control" id="promocion_tipo" placeholder="Tipo" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descuento" class="form-label">Descuento:</label>
                                        <input type="text" class="form-control" id="promocion_descuento" placeholder="Descuento" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="History" style="margin-bottom: 35px;">
        <div class="container">
            <h2 class="text-center mt-5"><u><i class='bx bx-book-open'></i> Historial de Reservas:</u></h2>
            <div class="form-group mt-3">
                <form class="inline-form" action="" method="POST">
                    <button type="submit" name="accion" value="ExportarPDF" class="btn btn-outline-danger"><i class="fa fa-file-pdf-o"></i> Exportar En Formato PDF</button>
                </form>
            </div>

            <table id="historyTable" class="table table-hover table-bordered mt-1">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Fecha Reserva</th>
                        <th class="text-center">Hora Reserva</th>
                        <th class="text-center">Nombre Cliente</th>
                        <th class="text-center">Apellido Cliente</th>
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