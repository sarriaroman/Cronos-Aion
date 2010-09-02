<?php


function loadProfiles() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, name, email, level from {$dbprefix}profile";

    $req = $con->make_request($sql);

    while( $profile = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
	echo '<h3 class="ui-widget-header ui-corner-all">' . $profile['name'] .  " (" . $profile['email'] . ')';
        if( $profile['level'] != User::$admin ) {
            echo '<a onclick="deleteProfile(' . $profile['id'] . ',\'' . $profile['name'] . '\');" title="Borrar\nusuario" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/cross.png" /></a>';
        }
        echo '</h3>';
    }
}

?>
