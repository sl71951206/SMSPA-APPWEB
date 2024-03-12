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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/es.js'></script>
</head>

<body id="body-pd" style="background-color: #dedede;">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        if ($_SESSION['useradmin'] === 'user') {
            include_once('assets/includes/dashboard2.php');
        } elseif ($_SESSION['useradmin'] === 'admin') {
            include_once('assets/includes/dashboard.php');
        }
    ?>

    <style>
        .fc-timegrid-slot-label-cushion {
            height: 70px;
            background-color: #2c3e50;
            color: #fff;
            border-color: #2c3e50;
            font-weight: bold;
        }
    </style>
    <section id="Calendar_Section" style="margin-bottom: 15px;margin-top: 15px;">
        <div id="calendar" style="background-color: white;padding: 20px;border-radius: 20px;" class="animate__animated animate__fadeIn"></div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                height: 600,
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                },
                businessHours: {
                    daysOfWeek: [0, 2, 3, 4, 5, 6], // De lunes a viernes
                    startTime: '09:30:00',
                    endTime: '18:00:00'
                },
                views: {
                    timeGrid: {
                        slotDuration: '00:30:00',
                        slotLabelInterval: '00:30:00',
                        allDaySlot: false,
                    }
                },
                slotMinTime: '09:30:00',
                slotMaxTime: '18:00:00',
                validRange: {
                    start: new Date(),
                    end: new Date().setDate(new Date().getDate() + 15) // Dos semanas desde la fecha actual
                },
                eventMouseEnter: function(info) {
                    info.el.style.cursor = 'pointer';
                },

                eventMouseLeave: function(info) {
                    info.el.style.cursor = '';
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Realizar la solicitud AJAX para obtener los eventos
                    $.ajax({
                        url: 'http://localhost:8080/spa/reservas/listarReservasRecientes',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var eventos = data.map(function(reserva) {
                                var color = null;
                                var fechaInicio = new Date(reserva.fecha + ' ' + reserva.hora);
                                var fechaFin = new Date(reserva.fecha + ' ' + reserva.hora);
                                fechaFin.setMinutes(fechaFin.getMinutes() + 30);

                                switch (reserva.id_servicio.nombre) {
                                    case 'Tratamiento Facial Hidratante':
                                        color = 'red';
                                        break;
                                    case 'Tratamiento Facial Hidratante':
                                        color = 'red';
                                        break;

                                    default:
                                        color = '#ff6666';
                                }

                                return {
                                    title: reserva.id_servicio.nombre,
                                    start: fechaInicio,
                                    end: fechaFin,
                                    backgroundColor: color,
                                    borderColor: '#ff6666'
                                };


                            });

                            // Llamar a la función de éxito de FullCalendar con los eventos
                            successCallback(eventos);
                        },
                        error: function(error) {
                            // Llamar a la función de error de FullCalendar
                            failureCallback(error);
                        }
                    });
                },
                eventClick: function(info) {
                    var title = info.event.title;
                    var start = info.event.start;
                    var end = info.event.end;

                    Swal.fire({
                        title: title,
                        html: '<strong>Inicio:</strong> ' + start.toLocaleString() + '<br><strong>Fin:</strong> ' + end.toLocaleString(),
                        icon: 'info',
                        confirmButtonText: 'Cerrar'
                    });
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>