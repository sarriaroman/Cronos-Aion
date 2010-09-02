<?php

function hace($fecha_unix) {
    //obtener la hora en formato unix
    $ahora=time();

    //obtener la diferencia de segundos
    $segundos=$ahora-$fecha_unix;

    //dias es la division de n segs entre 86400 segundos que representa un dia;
    $dias=floor($segundos/86400);

    //mod_hora es el sobrante, en horas, de la division de días;
    $mod_hora=$segundos%86400;

    //hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
    $horas=floor($mod_hora/3600);

    //mod_minuto es el sobrante, en minutos, de la division de horas;
    $mod_minuto=$mod_hora%3600;

    //minuto es la division entre el sobrante y 60 segundos que representa un minuto;
    $minutos=floor($mod_minuto/60);

    if($horas<=0) {
        return $minutos.' minutos';
    }elseif($dias<=0) {
        return $horas.' horas '.$minutos.' minutos';
    }else {
        return $dias.' dias '.$horas.' horas '.$minutos.' minutos';
    }
}

?>
