<?php

/**
 *
 * 	Gestor de accesos
 *
 */
class Log {

    const error = "ERROR";
    const info = "INFO";

    public static function info($did, $action) {
        $ip = getIP();

        $level = Log::info;

        $cnt = new Connection();
        $cnt->insert_data("insert into api_log (did, level, action, ip, created) values ('{$did}', '{$level}','{$action}', '{$ip}',now())");
    }

    public static function error($did, $action) {
        $ip = getIP();

        $level = Log::error;

        $cnt = new Connection();
        $cnt->insert_data("insert into api_log (did, level, action, ip, created) values ('{$did}', '{$level}','{$action}', '{$ip}',now())");
    }

}

?>