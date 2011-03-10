<?php

/**
 * 	Clase de manejo de la Salida
 *
 */

include( dirname(__FILE__) . "/xml/xml.php" );
include( dirname(__FILE__) . "/array2xml/array2xml.php" );

class Parser {

    var $type;
    var $arr;

    function __construct($t, $a) {
        $this->type = $t;
        $this->arr = $a;
    }

    function create() {
        switch ($this->type) {
            case "xml":
                header('Content-type: text/xml');
                $xml = new arr2xml($this->arr);
                echo $xml->get_xml();
                break;
            case "json":
                header('Content-type: application/json');
                echo json_encode($this->arr);
                break;
        }
    }

}

?>