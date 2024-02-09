var URL_BASE = "http://localhost:8080";

$(document).ready(function () {
  var id_servicio = null;
  ListarServicios();

  $("#crearServicioModal form").submit(function (event) {
    event.preventDefault();

    var nombre = $("#crearServicioModal #nombre").val();
    var descripcion = $("#crearServicioModal #descripcion").val();
    var duracion = $("#crearServicioModal #duracion").val();
    var precio = $("#crearServicioModal #precio").val();
    var urlImagen = $("#crearServicioModal #urlImagen").val();
    var categoria = $("#crearServicioModal #categoria").val();
    var favorito = $("#crearServicioModal #favorito").val();
    var estado = $("#crearServicioModal #estado").val();

    var data = {
      nombre: nombre,
      descripcion: descripcion,
      duracion: duracion,
      precio: precio,
      url_imagen: urlImagen,
      categoria: categoria,
      favorito: favorito,
      estado: estado,
    };

    $.ajax({
      url: URL_BASE + "/spa/servicios/registrar",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        $("#crearServicioModal").modal("hide");

        Swal.fire({
          title: "Registro Completado",
          text: "Servicio registrado con éxito",
          icon: "success",
        });

        $("#crearServicioModal form")[0].reset();

        ListarServicios();
      },
      error: function (error) {
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#servicesTable").on("click", ".btn-warning", function () {
    id_servicio = $(this).find("i").data("id");

    $.ajax({
      url: URL_BASE + "/spa/servicios/buscar/" + id_servicio,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarServicioModal #nombre").val(data.nombre);
        $("#editarServicioModal #descripcion").val(data.descripcion);
        $("#editarServicioModal #duracion").val(data.duracion);
        $("#editarServicioModal #precio").val(data.precio);
        $("#editarServicioModal #urlImagen").val(data.url_imagen);
        $("#editarServicioModal #categoria").val(data.categoria);
        $("#editarServicioModal #favorito").val(data.favorito ? "1" : "0");
        $("#editarServicioModal #estado").val(data.estado ? "1" : "0");

        // Mostrar el modal de edición
        $("#editarServicioModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información del servicio:", error);
      },
    });
  });

  $("#editarServicioModal form").submit(function (event) {
    event.preventDefault();

    var nombre = $("#editarServicioModal #nombre").val();
    var descripcion = $("#editarServicioModal #descripcion").val();
    var duracion = $("#editarServicioModal #duracion").val();
    var precio = $("#editarServicioModal #precio").val();
    var urlImagen = $("#editarServicioModal #urlImagen").val();
    var categoria = $("#editarServicioModal #categoria").val();
    var favorito = $("#editarServicioModal #favorito").val() === "1" ? true : false;
    var estado = $("#editarServicioModal #estado").val() === "1" ? true : false;

    var data = {
      nombre: nombre,
      descripcion: descripcion,
      duracion: duracion,
      precio: precio,
      url_imagen: urlImagen,
      categoria: categoria,
      favorito: favorito,
      estado: estado,
    };

    $.ajax({
      url: URL_BASE + "/spa/servicios/editar/" + id_servicio + "",
      type: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        $("#editarServicioModal").modal("hide");

        Swal.fire({
          title: "Edición Completada",
          text: "Servicio editado con éxito",
          icon: "success",
        });

        $("#editarServicioModal form")[0].reset();

        ListarServicios();
      },
      error: function (error) {
        console.error("Error en la edición:", error);
      },
    });
  });
});

function ListarServicios() {
  $.ajax({
    url: URL_BASE + "/spa/servicios/listar",
    method: "GET",
    dataType: "json",
    success: function (data) {
      // Limpiar la tabla
      $("#servicesTable tbody").empty();

      $.each(data, function (index, service) {
        var newRow = $("<tr>");
        newRow.append(
          '<td class="text-center">' + service.id_servicio + "</td>"
        );
        newRow.append('<td class="text-center">' + service.nombre +"</td>");
        newRow.append(
          '<td class="text-center">' + service.descripcion + "</td>"
        );
        newRow.append('<td class="text-center">' + service.duracion + " min."+"</td>");
        newRow.append('<td class="text-center">'+"S/"+ + service.precio + "</td>");
        newRow.append(
          '<td class="text-center"><img src="' +
            service.url_imagen +
            '" alt="' +
            service.nombre +
            '" style="max-width: 100px; max-height: 100px;"></td>'
        );
        newRow.append('<td class="text-center">' + service.categoria + "</td>");
        newRow.append(
          '<td class="text-center">' +
            (service.favorito ? "Sí" : "No") +
            "</td>"
        );
        newRow.append(
          '<td class="text-center">' +
            (service.estado ? "Activo" : "Inactivo") +
            "</td>"
        );
        newRow.append(
          '<td class="text-center"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarServicioModal"><i class="fa fa-edit" data-id="' +
            service.id_servicio +
            '"></i> Editar</button></td>'
        );

        $("#servicesTable tbody").append(newRow);
      });
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
