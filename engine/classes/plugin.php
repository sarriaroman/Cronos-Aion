<?php

class Plugin extends DataObject {

    function  __construct( $id = "" ) {
        global $dbprefix;

        parent::__construct("{$dbprefix}plugins", $id);
    }

    public static function getByPath( $path ) {
        global $dbprefix;
        $con = new Connection();

        $response = $con->make_request("select id from {$dbprefix}plugins where path = '{$path}';");
        if( ( $rs = mysql_fetch_object( $response ) ) ) {
            return new Plugin( $rs->id );
        } else {
            return false;
        }
    }

    public static function getByName( $name ) {
        global $dbprefix;
        $con = new Connection();

        $response = $con->make_request("select id from {$dbprefix}plugins where invoke_name = '{$name}';");
        if( ( $rs = mysql_fetch_object( $response ) ) ) {
            return new Plugin( $rs->id );
        } else {
            return false;
        }
    }
}

?>
