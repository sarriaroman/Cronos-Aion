<?php

function loadPrograms() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id from {$dbprefix}programs";

    $req = $con->make_request($sql);

    echo '<ol id="selectable">';
    while( $prog = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        $program = new Program( $prog['id'] );
	echo '<li class="ui-widget-content" id="' . $program->id . '"><img src="' . $program->image . '" width="25" height="25" />' . $program->name;
        echo '<a title="Eliminar programa" onclick="deleteProgram(' . $prog['id'] . ',\'' . $program->name . '\');" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/cross.png" /></a>';
        echo '<a onclick="modify(' . $program->id . ');" title="Modificar programa" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/page_edit.png" /></a>';
        echo '<a onclick="addschedule(' . $program->id . ');" title="Agregar programacion" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/calendar_add.png" /></a>';
        echo '</li>';
    }
    echo '</ol>';
}

function loadUsers() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, name from {$dbprefix}profile";

    $req = $con->make_request($sql);

    echo '<select id="cbusers" >';
        echo '<option value="-1">Sin audioblog</option>';

    while( $user = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        echo '<option value="' . $user['id'] . '">' . $user['name'] . '</option>';
    }

    echo '</select>';
}
?>
