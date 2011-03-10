<?php

function encode_string($string) {
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
    foreach (glob($carpeta . "/*") as $archivos_carpeta) {
        if (is_dir($archivos_carpeta))
            delDir($archivos_carpeta);
        else
            unlink($archivos_carpeta);
    }

    rmdir($carpeta);
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "&s=$s&r=$r";
    $url .= ( $d != "404" && $d != "mm" && $d != "identicon" && $d != "monsterid" && $d != "wavatar" ) ? "&d=" . urlencode($d) : "d={$d}";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function getCurrentSection() {
    $permalinks = explode("/", $_GET['url']);
    return $permalinks[0];
}

function getPermalink($position) {
    $permalinks = explode("/", $_GET['url']);

    return $permalinks[$position];
}

function getCurrentPath() {
    $permalinks = explode("/", $_GET['url']);
    foreach ($permalinks as $v)
        $result.= $v . "/";
    return substr($result, 0, -1);
    ;
}

function GoogleQRCode($text, $w, $h) {
    $text = urlencode($text);

    if ($w == "")
        $w = 100;
    if ($h == "")
        $h = 100;

    $url = "http://chart.apis.google.com/chart?cht=qr&chs={$w}x{$h}&chl={$text}&choe=UTF-8&chld=Q|1";

    return urldecode($url);
}

function ControlCodeGenerator($imei) {
    $imei = preg_replace("[^0-9]", "", $imei);

    $weights = array(8, 7, 4, 0, 1, 2, 5, 4, 3, 8, 1, 6, 9, 6, 7);
    $control;

    $weightedinput[15];

    for ($i = 0; $i < strlen($imei); $i++) {
        $weightedinput[$i] = intval(substr($imei, $i, 1)) * $weights[$i];
    }

    for ($i = 0; $i < count($weightedinput); $i++) {
        $control += $weightedinput[$i];
    }

    return $control % 100;
}
?>