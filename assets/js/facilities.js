$(document).ready(function () {
  var id_instalacion = null;
  ListarInstalaciones();

  $("#crearModal form").submit(function (event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();

    // Obtener los valores de los campos del formulario
    var rotulo = $("#crearModal #rotulo").val();
    var descripcion = $("#crearModal #descripcion").val();
    var estado = $("#crearModal #estado").val();

    // Construir el objeto de datos
    var data = {
      rotulo: rotulo,
      descripcion: descripcion,
      estado: estado,
    };

    $.ajax({
      url: "http://localhost:8080/spa/instalaciones/registrar",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después del registro exitoso
        $("#crearModal").modal("hide");

        Swal.fire({
          title: "Registro Completado",
          text: "Instalación registrada con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#crearModal form")[0].reset();

        ListarInstalaciones();
      },
      error: function (error) {
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#facilityTable").on("click", ".btn-warning", function () {
    id_instalacion = $(this).find("i").data("id");

    // Realizar una solicitud AJAX para obtener la información de la instalación con el id proporcionado
    $.ajax({
      url: "http://localhost:8080/spa/instalaciones/buscar/" + id_instalacion,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarModal #rotulo").val(data.rotulo);
        $("#editarModal #descripcion").val(data.descripcion);
        $("#editarModal #estado").val(data.estado ? "1" : "0");

        // Mostrar el modal de edición
        $("#editarModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información de la instalación:", error);
      },
    });
  });

  $("#editarModal form").submit(function (event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();

    // Obtener los valores de los campos del formulario
    var rotulo = $("#editarModal #rotulo").val();
    var descripcion = $("#editarModal #descripcion").val();
    var estado = $("#editarModal #estado").val() === "1" ? true : false;

    // Construir el objeto de datos
    var data = {
      rotulo: rotulo,
      descripcion: descripcion,
      estado: estado,
    };

    // Realizar la solicitud PUT a la dirección REST
    $.ajax({
      url:
        "http://localhost:8080/spa/instalaciones/editar/" + id_instalacion + "",
      type: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después de la edición exitosa
        $("#editarModal").modal("hide");

        Swal.fire({
          title: "Edición Completada",
          text: "Instalación editada con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#editarModal form")[0].reset();

        ListarInstalaciones();
      },
      error: function (error) {
        // Manejar errores
        console.error("Error en la edición:", error);
      },
    });
  });
});

function ListarInstalaciones() {
  $.ajax({
    url: "http://localhost:8080/spa/instalaciones/listar",
    method: "GET",
    dataType: "json",
    success: function (data) {
      // Limpiar la tabla
      $("#facilityTable tbody").empty();

      $.each(data, function (index, facility) {
        var newRow = $("<tr>");
        newRow.append(
          '<td class="text-center">' + facility.id_instalacion + "</td>"
        );
        newRow.append('<td class="text-center">' + facility.rotulo + "</td>");
        newRow.append(
          '<td class="text-center">' + facility.descripcion + "</td>"
        );
        newRow.append(
          '<td class="text-center">' +
            (facility.estado ? "Activo" : "Inactivo") +
            "</td>"
        );
        newRow.append(
          '<td class="text-center"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal"><i class="fa fa-edit" data-id="' +
            facility.id_instalacion +
            '"></i> Editar</button></td>'
        );

        $("#facilityTable tbody").append(newRow);
      });
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
