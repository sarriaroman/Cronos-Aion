<?php


function loadProfiles() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, name, username, email, level from {$dbprefix}profile";

    $req = $con->make_request($sql);

    $i = 0;
    while( $profile = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        if( ($i % 2) == 0 ) echo "<tr>";
        else echo '<tr class="odd">';
        
	echo '<td>' . $profile['name'] .  " (" . $profile['email'] . ')' . '</td>';

        echo '<td class="action">';

        if( $profile['username'] != "admin" ) {
            echo '<a onclick="deleteProfile(' . $profile['id'] . ',\'' . $profile['name'] . '\');" title="Borrar\nusuario" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'admin/images/cross.png" /></a>';
        }

        echo '</td>';

        echo '</tr>';

        $i++;
    }
}

?>
