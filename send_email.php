
<?php
require "PHPMailer/Exception.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generarContrasenaAleatoria($longitud) {
    try {
        $bytesAleatorios = random_bytes($longitud / 2);
        $contrasenaAleatoria = bin2hex($bytesAleatorios);
        return $contrasenaAleatoria;
    } catch (Exception $e) {
        return null;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'smspaperu@hotmail.com';
        $mail->Password = 'Elmejorspadelmundo';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('smspaperu@hotmail.com', 'Sm Spa Contacto');
        $mail->addAddress('smspaperu@hotmail.com', 'Sm Spa Contacto');
        $contrasenaGenerada = generarContrasenaAleatoria(10);
        if ($contrasenaGenerada !== null) {
            $mail->Subject = 'Recuperacion de la Contrasena';
            $mail->Body = "Contrasena Generada: " . $contrasenaGenerada;
        } else {

        }
        $mail->send();

        echo "
            <script>
                Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Mail Enviado con éxito',
                showConfirmButton: true,  // Mostrar el botón de confirmación
                timer: 5000  // Cerrar automáticamente después de 5 segundos (puedes ajustar el tiempo según tus necesidades)
            }).then(() => {
                //window.location.href = 'index.php';  
            </script>";
    } catch (Exception $e) {
        // Mensaje de error
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al enviar el correo: {$mail->ErrorInfo}',
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>";
    }
}
?>
