<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Post extends DataObject {

    function  __construct( $id = "" ) {
        global $dbprefix;

        parent::__construct("{$dbprefix}posts", $id);
    }

}

?>
