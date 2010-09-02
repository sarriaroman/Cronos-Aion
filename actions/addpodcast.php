<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

global $dbprefix;

$con = new Connection();

if( isset($_POST['pid']) && $_POST['pid'] != "" && $_POST['pid'] != "undefined" ) {

    $new = $con->update_data("UPDATE {$dbprefix}podcast SET
                      uid = '" 			. $_POST['uid'] .
                    "', tittle = '"		. $_POST['tittle'] .
                    "', date = '"			. $_POST['date'] .
                    "', duration = '"		. $_POST['duration'] .
                    "', description = '"	. encode_string( $_POST['description'] ) .
                    "', url = '"			. $_POST['url'] .
                    "', home = '"		. ( ($_POST['home'] == "true") ? "1" : "0" ) .
                    "', internal = '"		. ( ($_POST['internal'] == "true") ? "1" : "0" ) .
                    "', blog = '"		. ( ($_POST['blog'] == "true") ? "1" : "0" ) .
                    "' WHERE id = '" . $_POST['pid'] . "'");

} else {

    $sql = "INSERT INTO {$dbprefix}podcast (uid, tittle, date, duration, description, url, home, internal, blog, listen_count, upload_date) VALUES
														(" . $_POST['uid'] . 			",
														 '" . $_POST['tittle'] . 		"',
														 '" . $_POST['date'] . 			"',
														 '" . $_POST['duration'] . 		"',
														 '" . encode_string( $_POST['description'] ) . 	"',
														 '" . $_POST['url'] . 			"',
														 " . ( ($_POST['home'] == "true") ? "1" : "0" ) . 		",
                                                                                                                 " . ( ($_POST['internal'] == "true") ? "1" : "0" ) . 		",
                                                                                                                 " . ( ($_POST['blog'] == "on") ? "true" : "0" ) . 		",
														 0,
														 NOW())
												 ";

    $new = $con->insert_data( $sql );
}

if( !$new ) {
    if( $_POST['pid'] != "" ) {
        echo "<div style='display: none;'>updatesuccess</div><font color='green'>Podcast actualizado correctamente.</font>";
    } else {
        echo "<div style='display: none;'>success</div><font color='green'>Podcast cargado correctamente.</font>";
    }
    //if( Tag::insert_tags( ( empty($pid) ) ? Podcast::last_id( $user->uid ) : $pid , $_POST['tags']) ) {

    //}
} else {
    echo "<div style='display: none;'>error</div><font color='red'>Se produjo un error al cargar el podcast.</font>";
}

?>
