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
    var titulo = $("#crearModal #titulo").val();
    var descripcion = $("#crearModal #descripcion").val();
    var estado = $("#crearModal #estado").val();
    var fechaInicio = $("#crearModal #fechaInicio").val();
    var fechaFin = $("#crearModal #fechaFin").val();
    var urlImagen = $("#crearModal #urlImagen").val();
    var descuento = $("#crearModal #descuento").val();
    var tipo = $("#crearModal #tipo").val();
    var servicioRelacionado = $("#crearModal #servicioRelacionado").val();

    // Construir el objeto de datos
    var data = {
      titulo: titulo,
      descripcion: descripcion,
      estado: estado,
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      url_imagen: urlImagen,
      descuento: descuento,
      tipo: tipo,
      servicios: servicioRelacionado,
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
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#promotionsTable").on("click", ".btn-warning", function () {
    id_promocion = $(this).find("i").data("id");

    // Realizar una solicitud AJAX para obtener la información de la promoción con el id proporcionado
    $.ajax({
      url: URL_BASE + "/spa/promociones/buscar/" + id_promocion,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarModal #editTitulo").val(data.titulo);
        $("#editarModal #editDescripcion").val(data.descripcion);
        $("#editarModal #editEstado").val(data.estado ? "1" : "0");
        $("#editarModal #editFechaInicio").val(data.fecha_inicio);
        $("#editarModal #editFechaFin").val(data.fecha_fin);
        $("#editarModal #editUrlImagen").val(data.url_imagen);
        $("#editarModal #editDescuento").val(data.descuento);
        $("#editarModal #editTipo").val(data.tipo);
        $("#editarModal #servicioRelacionadoEditar").val(
          data.servicios
        );

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

    var titulo = $("#editarModal #editTitulo").val();
    var descripcion = $("#editarModal #editDescripcion").val();
    var estado = $("#editarModal #editEstado").val() === "1" ? true : false;
    var fechaInicio = $("#editarModal #editFechaInicio").val();
    var fechaFin = $("#editarModal #editFechaFin").val();
    var urlImagen = $("#editarModal #editUrlImagen").val();
    var descuento = $("#editarModal #editDescuento").val();
    var tipo = $("#editarModal #editTipo").val();
    var servicioRelacionado = $("#editarModal #servicioRelacionadoEditar").val();

    var data = {
      titulo: titulo,
      descripcion: descripcion,
      estado: estado,
      fecha_inicio: fechaInicio,
      fecha_fin: fechaFin,
      url_imagen: urlImagen,
      descuento: descuento,
      tipo: tipo,
      servicios: servicioRelacionado,
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
        // Manejar errores
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

        $.each(data, function (index, promotion) {
          var newRow = $("<tr>");
          newRow.append(
            '<td class="text-center">' + promotion.id_promocion + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + promotion.titulo + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + promotion.descripcion + "</td>"
          );
          newRow.append(
            '<td class="text-center">' +
              (promotion.estado ? "Activo" : "Inactivo") +
              "</td>"
          );
          var fechaInicioFormateada = formatearFecha(promotion.fecha_inicio);
          var fechaFinFormateada = formatearFecha(promotion.fecha_fin);

          newRow.append(
            '<td class="text-center">' + fechaInicioFormateada + "</td>"
          );
          newRow.append(
            '<td class="text-center">' + fechaFinFormateada + "</td>"
          );
          newRow.append(
            '<td class="text-center"><img src="' +
              promotion.url_imagen +
              '" alt="Imagen de la promoción" style="max-width: 100px;"></td>'
          );
          newRow.append(
            '<td class="text-center">' + promotion.descuento + "%" + "</td>"
          );
          newRow.append('<td class="text-center">' + promotion.tipo + "</td>");
          /*
          newRow.append(
            '<td class="text-center">' + promotion.servicios + "</td>"
          );
          */
          newRow.append(
            '<td class="text-center"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal"><i class="fa fa-edit" data-id="' +
              promotion.id_promocion +
              '"></i> Editar</button></td>'
          );

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
