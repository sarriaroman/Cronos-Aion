<?php

require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

$action = $_POST['action'];
if( empty( $action ) ) $action = $_GET['action'];

switch ( $action ) {

case "addpost":
        global $dbprefix;
        $con = new Connection();

        $post = addSlashes( $_POST['post'] );

        $rst = $con->insert_data("INSERT INTO {$dbprefix}blogpost (bid, tittle, post, created) VALUES
        									  ('" . $_POST['bid'] . "',
        									   '" . $_POST['tittle'] . "',
                                                                                   '" . $post . "',
           									    NOW())");
        if( rst ) {
            echo "ok";
        } else {
            echo "error";
        }

        break;

case "deletepost":
        global $dbprefix;
        $con = new Connection();

        $sql = "DELETE FROM {$dbprefix}blogpost WHERE id = '" . $_GET['id'] . "'";

        $rst = $con->delete_data( $sql );
        $rst = $con->delete_data("DELETE FROM {$dbprefix}blogcomments WHERE postid = {$_GET['id']}");

        echo "<script type='text/javascript'>
                $( function() {
                    $('#loadblogpost').load('" . modules_url . "admin_blogpost/blog.php?pid=" . $_GET['pid'] . "');
                } );
              </script>";

        break;
}

?>
