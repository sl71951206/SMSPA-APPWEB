<?php
session_start();
session_destroy();
header('Location: /php/aplicacion_web/index.php');
exit();
?>