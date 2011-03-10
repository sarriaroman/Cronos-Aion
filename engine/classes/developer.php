<?php

class Developer extends DataObject {

    function  __construct( $id = "" ) {
        global $dbprefix;

        parent::__construct("{$dbprefix}api_users", $id);
    }

}

?>
