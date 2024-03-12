var URL_BASE = "http://localhost:8080";
var URL_FOTO = "http://localhost:8080/spa/imagenes/"

$(document).ready(function () {
  var id_servicio = null;
  ListarServicios();

  $("#crearServicioModal form").submit(function (event) {
    event.preventDefault();

    var nombre = $("#crearServicioModal #nombre").val().trim();
    var descripcion = $("#crearServicioModal #descripcion").val().trim();
    var duracion = $("#crearServicioModal #duracion").val();
    var precio = $("#crearServicioModal #precio").val();
    var categoria = $("#crearServicioModal #categoria").val().trim();

    var data = {
      nombre: nombre,
      descripcion: descripcion,
      duracion: duracion,
      precio: precio,
      categoria: categoria,
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
        Swal.fire({
          title: "Error al registrar servicio",
          text: error.responseText,
          icon: "error",
        });
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#servicesTable").on("click", ".btn-warning", function () {
    id_servicio = $(this).closest("tr").data("id");

    $.ajax({
      url: URL_BASE + "/spa/servicios/buscar/" + id_servicio,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarServicioModal #nombre").val(data.nombre);
        $("#editarServicioModal #descripcion").val(data.descripcion);
        $("#editarServicioModal #duracion").val(data.duracion);
        $("#editarServicioModal #precio").val((data.precio/1).toFixed(2));
        $("#editarServicioModal #categoria").val(data.categoria);

        // Mostrar el modal de edición
        $("#editarServicioModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información del servicio:", error);
      },
    });
  });

  $("#servicesTable").on("click", ".estrella", function () {
    id_servicio = $(this).closest("tr").data("id");

    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Se editará el campo favorito de este servicio.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: URL_BASE + "/spa/servicios/favorito/" + id_servicio,
          method: "PUT",
          success: function () {
            ListarServicios();
          },
          error: function (error) {
            console.error("Error al cargar información del servicio:", error);
          },
        });
      } else {
        //
      }
    });
  });

  $("#servicesTable").on("click", ".btn-danger", function () {
    id_servicio = $(this).closest("tr").data("id");

    Swal.fire({
      title: '¿Estás seguro?',
      text: 'Se editará el campo estado de este servicio.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: URL_BASE + "/spa/servicios/inhabilitar/" + id_servicio,
          method: "PUT",
          success: function () {
            Swal.fire('Estado cambiado', 'Se ha modificado el estado correctamente.', 'success');
            ListarServicios();
          },
          error: function (error) {
            Swal.fire('Hubo errores', 'Verifica que todos los campos del servicio tengan los parámetros correctos antes de cambiar el estado.', 'error');
            console.error("Error al cargar información del servicio:", error);
          },
        });
      } else {
        //
      }
    });
  });

  $("#servicesTable").on("click", ".btn-info", function () {
    id_servicio = $(this).closest("tr").data("id");

    $.ajax({
      url: URL_BASE + "/spa/servicios/buscar/" + id_servicio,
      method: "GET",
      dataType: "json",
      success: function (data) {
        if (data.url_imagen != null) {
          $("#imagenServicioModal #imagen").attr("src", URL_FOTO + data.url_imagen);
          $("#imagenServicioModal #imagen").attr("alt", data.nombre);
        } else {
          $("#imagenServicioModal #imagen").attr("src", "");
          $("#imagenServicioModal #imagen").attr("alt", "No hay imagen.");
        }
        $("#imagenServicioModal #nombre_imagen").val(data.url_imagen);
        $("#imagenServicioModal #archivo_imagen").val("");
        // Mostrar el modal de imagen
        $("#imagenServicioModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información del servicio:", error);
      },
    });
  });

  $("#imagenServicioModal form").submit(function (event) {
    event.preventDefault();

    var nombre_imagen = $("#imagenServicioModal #nombre_imagen").val().trim();
    var archivo_imagen = $("#imagenServicioModal #archivo_imagen")[0].files[0];

    var formData = new FormData();
    formData.append("file", archivo_imagen);

    $.ajax({
      url: URL_BASE + "/spa/imagenes/upload/" + id_servicio + "/" + nombre_imagen,
      type: "POST",
      processData: false,
      contentType: false,
      data: formData,
      success: function (response) {
        $("#imagenServicioModal").modal("hide");

        Swal.fire({
          title: "Imagen subida",
          text: "Imagen subida al servicio con éxito.",
          icon: "success",
        });

        $("#imagenServicioModal form")[0].reset();

        ListarServicios();
      },
      error: function (error) {
        Swal.fire({
          title: "Error al subir imagen",
          text: error.responseText,
          icon: "error",
        });
        console.error("Error en la edición:", error);
      },
    });
  });

  $("#editarServicioModal form").submit(function (event) {
    event.preventDefault();

    var nombre = $("#editarServicioModal #nombre").val().trim();
    var descripcion = $("#editarServicioModal #descripcion").val().trim();
    var duracion = $("#editarServicioModal #duracion").val();
    var precio = $("#editarServicioModal #precio").val();
    var categoria = $("#editarServicioModal #categoria").val().trim();

    var data = {
      nombre: nombre,
      descripcion: descripcion,
      duracion: duracion,
      precio: precio,
      categoria: categoria,
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
        Swal.fire({
          title: "Error al registrar promoción",
          text: error.responseText,
          icon: "error",
        });
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
      var cont = 0;
      $.each(data, function (index, service) {
        cont++;
        if (service.estado) {
          var newRow = $('<tr data-id="' + service.id_servicio + '">');
        } else {
          var newRow = $('<tr class="bg-secondary text-white" data-id="' + service.id_servicio + '">');
        }
        /*newRow.append(
          '<td class="text-center">' + service.id_servicio + "</td>"
        );*/
        newRow.append('<td class="text-center">' + cont +"</td>");
        newRow.append('<td class="text-center">' + service.nombre +"</td>");
        newRow.append(
          '<td class="text-center">' + service.descripcion + "</td>"
        );
        newRow.append('<td class="text-center">' + service.duracion + " min"+"</td>");
        newRow.append('<td class="text-center">'+"S/ "+ service.precio + "</td>");
        /*newRow.append(
          '<td class="text-center"><img src="' +
            service.url_imagen +
            '" alt="' +
            service.nombre +
            '" style="max-width: 100px; max-height: 100px;"></td>'
        );*/
        newRow.append('<td class="text-center">' + service.categoria + "</td>");
        if (!service.estado) {
          newRow.append(
          '<td class="text-center"><i class="fa fa-star-half-o blackstar"></i></td>'
          );
        } else if (service.favorito) {
          newRow.append(
          '<td class="text-center"><i class="fa fa-star text-warning estrella"></i></td>'
          );
        } else {
          newRow.append(
          '<td class="text-center"><i class="fa fa-star-o text-warning estrella"></i></td>'
          );
        }
        /*newRow.append(
          '<td class="text-center">' +
            (service.estado ? "Activo" : "Inactivo") +
            "</td>"
        );*/
        if (service.url_imagen != null) {
          var btn_img = '<button type="button" class="btn btn-info"><i class="fa fa-image" title="Imagen"></i></button>'
        } else {
          var btn_img = '<button type="button" class="btn btn-info"><i class="fa fa-upload" title="Imagen"></i></button>'
        }
        var btn_edit = '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarServicioModal" title="Editar"><i class="fa fa-edit"></i></button>';
        var btn_hab = '<button type="button" class="btn btn-danger"><i class="fa fa-archive" ';
        if (service.estado) {
          btn_hab = btn_hab + 'title="Inhabilitar"></i></button>';
        } else {
          btn_hab = btn_hab + 'title="Habilitar"></i></button>';
        }
        newRow.append('<td class="text-center">' + btn_img + btn_edit + btn_hab + '</td>');
        $("#servicesTable tbody").append(newRow);
      });
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
