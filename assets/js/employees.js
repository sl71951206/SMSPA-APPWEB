var URL_BASE = "http://localhost:8080";

$(document).ready(function () {
  var id_empleado = null;
  ListarEmpleados();

  $("#crearModal form").submit(function (event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();

    // Obtener los valores de los campos del formulario
    var nombres = $("#crearModal #nombres").val();
    var apellidos = $("#crearModal #apellidos").val();
    var urlImagen = $("#crearModal #urlImagen").val();
    var estado = $("#crearModal #estado").val();
    var telefono = $("#crearModal #telefono").val();
    var correo = $("#crearModal #correo").val();
    var descripcion = $("#crearModal #descripcion").val();

    // Construir el objeto de datos
    var data = {
      nombres: nombres,
      apellidos: apellidos,
      url_foto: urlImagen,
      estado: estado,
      telefono: telefono,
      correo: correo,
      descripcion: descripcion,
    };

    $.ajax({
      url: URL_BASE + "/spa/empleados/registrar",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después del registro exitoso
        $("#crearModal").modal("hide");

        Swal.fire({
          title: "Registro Completado",
          text: "Empleado registrado con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#crearModal form")[0].reset();

        ListarEmpleados();
      },
      error: function (error) {
        console.error("Error en el registro:", error);
      },
    });
  });

  $("#employeeTable").on("click", ".btn-warning", function () {
    id_empleado = $(this).find("i").data("id");

    // Realizar una solicitud AJAX para obtener la información del empleado con el id proporcionado
    $.ajax({
      url: URL_BASE + "/spa/empleados/buscar/" + id_empleado,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#editarModal #nombres").val(data.nombres);
        $("#editarModal #apellidos").val(data.apellidos);
        $("#editarModal #urlImagen").val(data.url_foto);
        $("#editarModal #estado").val(data.estado ? "1" : "0");
        $("#editarModal #telefono").val(data.telefono);
        $("#editarModal #correo").val(data.correo);
        $("#editarModal #descripcion").val(data.descripcion);

        // Mostrar el modal de edición
        $("#editarModal").modal("show");
      },
      error: function (error) {
        console.error("Error al cargar información del empleado:", error);
      },
    });
  });

  $("#editarModal form").submit(function (event) {
    // Prevenir el comportamiento predeterminado del formulario
    event.preventDefault();

    // Obtener los valores de los campos del formulario
    var nombres = $("#editarModal #nombres").val();
    var apellidos = $("#editarModal #apellidos").val();
    var urlImagen = $("#editarModal #urlImagen").val();
    var estado = $("#editarModal #estado").val() === "1" ? true : false;
    var telefono = $("#editarModal #telefono").val();
    var correo = $("#editarModal #correo").val();
    var descripcion = $("#editarModal #descripcion").val();

    // Construir el objeto de datos
    var data = {
      nombres: nombres,
      apellidos: apellidos,
      url_foto: urlImagen,
      estado: estado,
      telefono: telefono,
      correo: correo,
      descripcion: descripcion,
    };

    // Realizar la solicitud PUT a la dirección REST
    $.ajax({
      url: URL_BASE + "/spa/empleados/editar/" + id_empleado + "",
      type: "PUT",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        // Cerrar el modal después de la edición exitosa
        $("#editarModal").modal("hide");

        Swal.fire({
          title: "Edición Completada",
          text: "Empleado editado con éxito",
          icon: "success",
        });

        // Limpiar los campos del formulario
        $("#editarModal form")[0].reset();

        ListarEmpleados();
      },
      error: function (error) {
        // Manejar errores
        console.error("Error en la edición:", error);
      },
    });
  });
});

function ListarEmpleados() {
  $.ajax({
    url: URL_BASE + "/spa/empleados/listar",
    method: "GET",
    dataType: "json",
    success: function (data) {
      // Limpiar la tabla
      $("#employeeTable tbody").empty();

      $.each(data, function (index, employee) {
        var newRow = $("<tr>");
        newRow.append(
          '<td class="text-center">' + employee.id_empleado + "</td>"
        );
        newRow.append('<td class="text-center">' + employee.nombres + "</td>");
        newRow.append(
          '<td class="text-center">' + employee.apellidos + "</td>"
        );
        newRow.append('<td class="text-center">' + employee.correo + "</td>");
        newRow.append('<td class="text-center">' + employee.telefono + "</td>");
        newRow.append(
          '<td class="text-center"><img src="' +
            employee.url_foto +
            '" alt="' +
            employee.nombres +
            '" style="max-width: 100px; max-height: 100px;"></td>'
        );
        newRow.append(
          '<td class="text-center">' +
            (employee.estado ? "Activo" : "Inactivo") +
            "</td>"
        );
        newRow.append('<td class="text-center">' + employee.descripcion + "</td>");
        newRow.append(
          '<td class="text-center"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal"><i class="fa fa-edit" data-id="' +
            employee.id_empleado +
            '"></i> Editar</button></td>'
        );

        $("#employeeTable tbody").append(newRow);
      });
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
