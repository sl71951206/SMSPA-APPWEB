var URL_BASE = "http://localhost:8080";

$(document).ready(function () {
  ListarReservas();

  // Función para listar reservas
  function ListarReservas() {
    $.ajax({
      url: URL_BASE + "/spa/reservas/listarReservasPasadas/0",
      method: "GET",
      dataType: "json",
      success: function (data) {
        // Limpiar la tabla de reservas
        $("#historyTable tbody").empty();

        // Iterar sobre los datos y agregar filas a la tabla
        $.each(data, function (index, reserva) {
          var newRow = $("<tr>");
          newRow.append(
            '<td class="text-center">' + reserva.id_reserva + "</td>"
          );
          newRow.append('<td class="text-center">' + reserva.fecha + "</td>");
          newRow.append('<td class="text-center">' + reserva.hora + "</td>");
          newRow.append(
            '<td class="text-center">' + reserva.nombres_cliente + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + reserva.apellidos_cliente + "</td>"
          );
          newRow.append(
            '<td class="text-center"><button type="button" class="btn btn-primary btnDetalle" data-bs-toggle="modal" data-bs-target="#verDetalleModal" data-id="' +
              reserva.id_reserva +
              '"><i class="bx bxs-detail"></i> Ver Detalle</button></td>'
          );

          // Agregar la fila a la tabla
          $("#historyTable tbody").append(newRow);
        });
      },
      error: function (error) {
        console.error("Error en la solicitud AJAX:", error);
      },
    });
  }

  // Delegación de eventos para elementos dinámicos
  $("#historyTable tbody").on("click", ".btnDetalle", function () {
    var reservaId = $(this).data("id");
    MostrarDetalleReserva(reservaId);
  });

  // Función para mostrar detalles de reserva en el modal
  function MostrarDetalleReserva(idReserva) {
    $.ajax({
      url: URL_BASE + "/spa/reservas/buscar/" + idReserva,
      method: "GET",
      dataType: "json",
      success: function (detalleReserva) {
        // Llena los campos del modal con los detalles de la reserva
        $("#verDetalleModal #servicio_nombre").val(
          detalleReserva.id_servicio.nombre
        );
        $("#verDetalleModal #servicio_duracion").val(
          detalleReserva.id_servicio.duracion+" min."
        );
        $("#verDetalleModal #servicio_precio").val(
          "S/ "+detalleReserva.id_servicio.precio
        );
        $("#verDetalleModal #servicio_fechahora").val(
          detalleReserva.fecha + " - " + detalleReserva.hora
        );
        $("#verDetalleModal #cliente_nombre").val(
          detalleReserva.nombres_cliente
        );
        $("#verDetalleModal #cliente_apellidos").val(
          detalleReserva.apellidos_cliente
        );
        $("#verDetalleModal #cliente_correo").val(
          detalleReserva.correo_cliente
        );
        $("#verDetalleModal #cliente_telefono").val(
          detalleReserva.telefono_cliente
        );
        $("#verDetalleModal #empleado_nombre").val(
          detalleReserva.id_empleado.nombres
        );
        $("#verDetalleModal #empleado_apellidos").val(
          detalleReserva.id_empleado.apellidos
        );
        $("#verDetalleModal #empleado_correo").val(
          detalleReserva.id_empleado.correo
        );
        $("#verDetalleModal #empleado_instalacion").val(
          detalleReserva.id_instalacion.rotulo
        );

        // Verifica si hay promoción asociada a la reserva
        if (detalleReserva.id_promocion) {
          $("#verDetalleModal #promocion_titulo").val(
            detalleReserva.id_promocion.titulo
          );
          $("#verDetalleModal #promocion_tipo").val(
            detalleReserva.id_promocion.tipo
          );
          $("#verDetalleModal #promocion_descuento").val(
            detalleReserva.id_promocion.descuento
          );
        } else {
          // Si no hay promoción, deshabilita los campos correspondientes
          $(
            "#verDetalleModal #promocion_titulo, #verDetalleModal #promocion_tipo, #verDetalleModal #promocion_descuento"
          )
            .val("No Aplica Promoción")
            .prop("disabled", true)
            .css({
                'color': 'red',
                'font-weight':'bold'
            });
            
        }

        // Mostrar el modal de detalles
        $("#verDetalleModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar detalles de la reserva:", error);
      },
    });
  }
});
