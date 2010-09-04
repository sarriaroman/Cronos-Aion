<?php

function encode_string( $string ) {
    $arr = array(
            "á" => "&aacute;",
            "Á" => "&Aacute;",
            "é" => "&eacute;",
            "É" => "&Eacute;",
            "í" => "&iacute;",
            "Í" => "&Iacute;",
            "ó" => "&oacute;",
            "Ó" => "&Oacute;",
            "ú" => "&uacute;",
            "Ú" => "&Uacute;",
            "ñ" => "&ntilde;",
            "Ñ" => "&Ntilde;",
            "°" => "&deg;",
            "\"" => "&quot;"
    );

    return str_ireplace(array_keys($arr), array_values($arr), $string);
}

function deldir($carpeta) {
    foreach(glob($carpeta."/*") as $archivos_carpeta) {
        if(is_dir($archivos_carpeta)) delDir($archivos_carpeta);
        else unlink($archivos_carpeta);
    }

    rmdir($carpeta);
}

?>