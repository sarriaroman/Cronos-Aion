<?php

class Table extends DataObject {

    function  __construct( $table, $id = "" ) {
        global $dbprefix;

        parent::__construct( $table, $id);
    }

}

?>
