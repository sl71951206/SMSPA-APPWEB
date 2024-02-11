<?php
session_start();
session_destroy();
header('Location: /php/SMSPA-APPWEB/index.php');
exit();
?>