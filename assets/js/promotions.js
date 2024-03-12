var URL_BASE = "http://localhost:8080";

$(document).ready(function () {
  var id_promocion = null;
  ListarPromociones();
  cargarServiciosDisponibles();
  cargarTodoslosServicios();

  $("#crearModal form").submit(function (event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();

    // Obtener los valores de los campos del formulario
    var titulo = $("#crearModal #titulo").val().trim();
    var descuento = $("#crearModal #descuento").val();
    var tipo = $("#crearModal #tipo").val();
    var fechaInicio = $("#crearModal #fechaInicio").val();
    var fechaFin = $("#crearModal #fechaFin").val();
    var descripcion = $("#crearModal #descripcion").val().trim();

    // Construir el objeto de datos
    var data = {
      titulo: titulo,
      descuento: descuento,
      tipo: tipo,
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      descripcion: descripcion,
    };

    $.ajax({
      url: URL_BASE + "/spa/promociones/registrar",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después del registro exitoso
        $("#crearModal").modal("hide");

        Swal.fire({
          title: "Registro Completado",
          text: "Promoción registrada con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#crearModal form")[0].reset();

        ListarPromociones();
      },
      error: function (error) {
        Swal.fire({
          title: "Error al registrar promoción",
          text: error.responseText,
          icon: "error",
        });
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#promotionsTable").on("click", ".btn-warning", function () {
    id_promocion = $(this).closest("tr").data("id");

    // Realizar una solicitud AJAX para obtener la información de la promoción con el id proporcionado
    $.ajax({
      url: URL_BASE + "/spa/promociones/buscar/" + id_promocion,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarModal #editTitulo").val(data.titulo);
        $("#editarModal #editDescuento").val(data.descuento);
        $("#editarModal #editTipo").val(data.tipo);
        $("#editarModal #editFechaInicio").val(data.fecha_inicio);
        $("#editarModal #editFechaFin").val(data.fecha_fin);
        $("#editarModal #editDescripcion").val(data.descripcion);

        // Mostrar el modal de edición
        $("#editarModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información de la promoción:", error);
      },
    });
  });

  $("#editarModal form").submit(function (event) {
    event.preventDefault();

    var titulo = $("#editarModal #editTitulo").val().trim();
    var descuento = $("#editarModal #editDescuento").val();
    var tipo = $("#editarModal #editTipo").val();
    var fechaInicio = $("#editarModal #editFechaInicio").val();
    var fechaFin = $("#editarModal #editFechaFin").val();
    var descripcion = $("#editarModal #editDescripcion").val().trim();

    var data = {
      titulo: titulo,
      descuento: descuento,
      tipo: tipo,
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      descripcion: descripcion,
    };

    $.ajax({
      url: URL_BASE + "/spa/promociones/editar/" + id_promocion,
      type: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después de la edición exitosa
        $("#editarModal").modal("hide");

        Swal.fire({
          title: "Edición Completada",
          text: "Promoción editada con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#editarModal form")[0].reset();

        ListarPromociones();
      },
      error: function (error) {
        Swal.fire({
          title: "Error al registrar promoción",
          text: error.responseText,
          icon: "error",
        });
        console.error("Error en la edición:", error);
      },
    });
  });

  function ListarPromociones() {
    $.ajax({
      url: URL_BASE + "/spa/promociones/listar",
      method: "GET",
      dataType: "json",
      success: function (data) {
        // Limpiar la tabla
        $("#promotionsTable tbody").empty();
        var cont = 0;
        $.each(data, function (index, promotion) {
          cont++;
          if (promotion.estado) {
            var newRow = $('<tr data-id="' + promotion.id_promocion + '">');
          } else {
            var newRow = $('<tr class="bg-secondary text-white" data-id="' + promotion.id_promocion + '">');
          }
          newRow.append(
            '<td class="text-center">' + cont + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + promotion.titulo + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + promotion.descuento + "</td>"
          );
          newRow.append('<td class="text-center">' + promotion.tipo + "</td>");
          var fechaInicioFormateada = formatearFecha(promotion.fecha_inicio);
          var fechaFinFormateada = formatearFecha(promotion.fecha_fin);
          newRow.append(
            '<td class="text-center">' + fechaInicioFormateada + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + fechaFinFormateada + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + promotion.descripcion + "</td>"
          );
          if (promotion.url_imagen != null) {
            var btn_img = '<button type="button" class="btn btn-info"><i class="fa fa-image" title="Imagen"></i></button>'
          } else {
            var btn_img = '<button type="button" class="btn btn-info"><i class="fa fa-upload" title="Imagen"></i></button>'
          }
          var btn_edit = '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal" title="Editar"><i class="fa fa-edit"></i></button>';
          var btn_hab = '<button type="button" class="btn btn-danger"><i class="fa fa-archive" ';
          if (promotion.estado) {
            btn_hab = btn_hab + 'title="Inhabilitar"></i></button>';
          } else {
            btn_hab = btn_hab + 'title="Habilitar"></i></button>';
          }
          newRow.append('<td class="text-center">' + btn_img + btn_edit + btn_hab + '</td>');
          $("#promotionsTable tbody").append(newRow);
        });
      },
      error: function (error) {
        console.error("Error en la solicitud AJAX:", error);
      },
    });
  }

  function formatearFecha(fecha) {
    var partes = fecha.split("T")[0].split("-");
    return partes[2] + "/" + partes[1] + "/" + partes[0];
  }

  function cargarServiciosDisponibles() {
    $.ajax({
      url: URL_BASE + "/spa/servicios/listarServiciosSinPromociones",
      method: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (index, servicio) {
          $("#crearModal #servicioRelacionado").append(
            '<option value="' +
              servicio.value +
              '">' +
              servicio.nombre +
              "</option>"
          );
        });
      },
      error: function (error) {
        console.error("Error al cargar servicios disponibles:", error);
      },
    });
  }

  function cargarTodoslosServicios(){

    $.ajax({
      url: URL_BASE + "/spa/servicios/listarServiciosSinPromociones",
      method: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (index, servicio) {
          $("#editarModal #servicioRelacionadoEditar").append(
            '<option value="' +
              servicio.value +
              '">' +
              servicio.nombre +
              "</option>"
          );
        });
      },
      error: function (error) {
        console.error("Error al cargar servicios disponibles:", error);
      },
    });

  }
});
