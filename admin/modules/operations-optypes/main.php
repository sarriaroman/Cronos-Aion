<?php

function loadTypes() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id from {$dbprefix}OpTypes";

    $req = $con->make_request($sql);

    $i = 0;
    while( $t = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        $type = new OpTypes( $t['id'] );

        if( ($i % 2) == 0 ) echo "<tr>";
        else echo '<tr class="odd">';

	echo '<td>' . $type->name .  " (" . $type->code . ')' . '</td>';

        echo '<td class="action">';

        echo '<span class="delete"><a onclick="deleteType(' . $type->id . ',\'' . $type->name . '\');" title="Borrar usuario">Borrar</a></span>';

        echo '</td>';

        echo '</tr>';

        $i++;
    }
}

function loadRevenues() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, name, percentage from {$dbprefix}revenues order by name";

    $req = $con->make_request($sql);

    while( $cat = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
	echo '<option value="' . $cat['id'] . '">' . $cat['name'] . ( ( $cat['percentage'] == 0 ) ? " (Monto)" : " (Porcentaje)" ) . '</option>';
    }
}

?>
