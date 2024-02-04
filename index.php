<?php
    session_start();
    error_reporting(0);

    if (isset($_POST['signin'])) {
        $useradmin = isset($_POST['options']) ? $_POST['options'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if ($useradmin === 'user' && $password !== '') {
            $sec = "assets/sec/user.txt";
            $contenido = file_get_contents($sec);
            if ($contenido == $password) {
                $_SESSION['useradmin'] = $useradmin;
                header('location:dashboard.php');
            } else {
                $msg = "Contraseña no es correcta.";
            }
        } elseif ($useradmin === 'admin' && $password !== '') {
            $sec = "assets/sec/admin.txt";
            $contenido = file_get_contents($sec);
            if ($contenido == $password) {
                $_SESSION['useradmin'] = $useradmin;
                header('location:dashboard.php');
            } else {
                $msg = "Contraseña no es correcta.";
            }
        } else {
            $msg = "Nombre de usuario '" . $useradmin . "' no es válido.";
        }
    }
?>

<!doctype html>
<html lang="es">

<head>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <title>SM Spa | Admin.</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body style="background-color: #dedede;">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section id="Sign_In">
        <div class="login">
            <div class="card">
                <form class="card-body" method="post">
                    <div class="form-group">
                        <h4>Ingrese la contraseña</h4>
                        <select class="form-control" name="options">
                            <option value="user">Recepcionista</option>
                            <option value="admin">Administrador</option>
                        </select>
                        <input class="form-control input-medio" type="password" name="password" placeholder="******"
                            required="true">
                        <small><?php if (isset($msg)) { echo $msg; } ?></small>
                        <div class="botones">
                            <input type="submit" class="btn btn-success" name="signin" value="Iniciar sesión">
                            <a id="Forgot-password" type="post" name="recuperar_password" style="cursor: pointer;color: blue;"><u>Recuperar Contraseña</u></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
$("#Forgot-password").on("click", function () {
    Swal.fire({
        title: '¿Desea continuar?',
        text: 'Está a punto de enviar un Correo de Recuperación de Contraseña',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'send_email.php',
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Mail de Recuperación enviado con éxito',
                        timer: 2500,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                },
                error: function (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al enviar el correo',
                    });
                }
            });
        }
    });
});

</script>
</html>
