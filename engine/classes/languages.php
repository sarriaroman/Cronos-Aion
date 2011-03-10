<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Languages extends DataObject {

    function  __construct( $id = "" ) {
        global $dbprefix;

        parent::__construct("{$dbprefix}languages", $id);
    }

    public static function getTags(){
        global $dbprefix;
        $conn = new Connection();

        return $conn->make_request("SELECT * FROM {$dbprefix}languages ORDER BY tag ASC");
    }
    public static function getSingleTag($id){
        global $dbprefix;
        $conn = new Connection();

        return $conn->make_request("SELECT * FROM {$dbprefix}languages WHERE id = '{$id}'");
    }
    public static function getSectionsTags($section){
        global $dbprefix;
        $conn = new Connection();

        return $conn->make_request("SELECT * FROM {$dbprefix}languages WHERE section='{$section}' AND lang='es' ORDER BY tag ASC");
    }
    public static function getOtherLanguage($tag,$id){
        global $dbprefix;
        $conn = new Connection();

        return $conn->make_request("SELECT * FROM {$dbprefix}languages WHERE tag='{$tag}' AND id !={$id}");
    }
    
}

?>
