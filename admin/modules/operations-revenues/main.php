<?php

function loadRevenues() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id from {$dbprefix}revenues";

    $req = $con->make_request($sql);

    $i = 0;
    while( $t = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        $type = new Revenue( $t['id'] );

        if( ($i % 2) == 0 ) echo "<tr>";
        else echo '<tr class="odd">';

	echo '<td>' . $type->name .  " (" . $type->code . ')' . '</td>';

        echo '<td class="action">';

        echo '<span class="delete" onclick="deleteRevenue(' . $type->id . ',\'' . $type->name . '\');">Borrar</span>';

        echo '</td>';

        echo '</tr>';

        $i++;
    }
}

?>
