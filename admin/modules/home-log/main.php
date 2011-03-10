<?php

function loadLog() {
    $con = new Connection();

    $query = $con->make_request("select * from aion_log where todo = 0;");

    $i = 0;
    while( $log = mysql_fetch_object($query) ) {
        echo '<tr ' . ( ( ($i % 2) == 0 ) ? '' : 'class="odd"' ) . '>
            <td>' . $log->description . '</td>
            <td class="action">
                <span class="delete">' . $log->created . '</span>
            </td>
        </tr>';
        $i++;
    }
}

function loadTodoLog() {
    $con = new Connection();

    $query = $con->make_request("select * from aion_log where todo = 1;");

    $i = 0;
    while( $log = mysql_fetch_object($query) ) {
        echo '<tr ' . ( ( ($i % 2) == 0 ) ? '' : 'class="odd"' ) . '>
            <td>' . $log->description . '</td>
            <td class="action">
                <span class="delete">' . $log->created . '</span>
            </td>
        </tr>';
        $i++;
    }
}

?>
