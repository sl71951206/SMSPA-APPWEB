<?php
$url = $url_base . "/miscelaneas/" . urlencode($useradmin);
            $cliente_url = curl_init($url);
            curl_setopt($cliente_url, CURLOPT_RETURNTRANSFER, true);
            $cuerpo_url = array('contrasena' => $password);
            curl_setopt($cliente_url, CURLOPT_POSTFIELDS, http_build_query($cuerpo_url));
            $respuesta_url = curl_exec($cliente_url);
            if (curl_errno($cliente_url)) {
                $msg = "Un error ha ocurrido al conectarse con el servicio web. [ ERROR: " . curl_error($cliente_url) . " ]";
            }
            curl_close($cliente_url);
            if ($respuesta_url === 's') {

            } else {
                $msg = "Contraseña '" . $password . "'no es correcta.";
            }
?>