<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

global $dbprefix;

$con = new Connection();

if( isset($_POST['pid']) ) $podcast = new Podcast( $_POST['pid'] );
else $podcast = new Podcast();

$podcast->Uid = $_POST['uid'];
$podcast->Tittle = $_POST['tittle'];
$podcast->Date = $_POST['date'];
$podcast->Duration = $_POST['duration'];
$podcast->Description = normalize_string( $_POST['description'] );
$podcast->Url = $_POST['url'];
$podcast->Home = ( ($_POST['home'] == "on") ? "1" : "0" );
$podcast->Internal = ( ($_POST['internal'] == "on") ? "1" : "0" );
$podcast->Blog = ( ($_POST['blog'] == "on") ? "1" : "0" );

if( $podcast->save() ) {
    echo "<div style='display: none;'>success</div><font color='green'>Podcast cargado correctamente.</font>";
    //if( Tag::insert_tags( ( empty($pid) ) ? Podcast::last_id( $user->uid ) : $pid , $_POST['tags']) ) {

    //}
} else {
    echo "<div style='display: none;'>error</div><font color='red'>Se produjo un error al cargar el podcast.</font>";
}

?>
