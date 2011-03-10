<?php

function loadUsers() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select u.id, d.id as did, d.api_key as api from {$dbprefix}users as u left join {$dbprefix}api_users as d on u.id = d.uid group by u.id;";

    $req = $con->make_request($sql);

    while( $t = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        $user = new Users( $t['id'] );

        echo "<tr>";

	echo '<td>' . $user->name .  " ( " . $user->username . ' )' . '</td>';

        echo '<td class="action">';

        echo '<span class="delete" onclick="deleteUser(' . $user->id . ',\'' . $user->name . '\');" style="cursor: pointer;">Borrar</span>'; //<img src="' . base_url . 'admin/images/cross.png" />
        echo '<span class="view"><a onclick="viewuser('.$user->id.');" title="Ver Usuario">ver</a></span>';

        echo '</td>';

        echo '</tr>';

        echo '<tr class="odd">';
        echo '<td> -> Clave API: ' . $t['api'] . " " . '</td>';

        echo '<td class="action">';
            if( $t['api'] ) {
                echo '<span class="delete"><a onclick="deleteDeveloper(' . $t['did'] . ',\'' . $user->name . '\');" title="Borrar Desarrollador">Borrar</a></span>';
            } else {
                echo '<span class="view"><a onclick="addDeveloper(' . $user->id . ',\'' . $user->name . '\');" title="Agregar desarrollador">Agregar</a></span>';
            }
        echo '</td>';
        echo '</tr>';
    }
}

?>
