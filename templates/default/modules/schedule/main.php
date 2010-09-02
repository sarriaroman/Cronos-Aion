<?php

require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/engine/start.php" );

if( isset( $_GET['day'] ) && isset( $_GET['offset'] ) ) {
    $d = $_GET['day'];
    $o = $_GET['offset'];
    loadPrograms( $d , $o );
}

function loadPrograms( $day, $offset = 0 ) {

    global $dbprefix;
    $con = new Connection();

    $position = $offset * 12;

    $sql = "select progid, fromTime, toTime from {$dbprefix}schedule where day = '{$day}' order by fromTime ASC limit {$position}, 12";

    if( $req = $con->make_request( $sql ) ) {

        while( $rst = mysql_fetch_array($req, MYSQL_ASSOC) ) {
            if( empty( $rst['progid'] ) ) return false;

            $program = new Program( $rst['progid'] );

            echo '<div id="program">
                    <div id="ThumbProgram"><img src="' . ( ( empty ($program->image) ) ? (template_url . "imgs/red/users/noPic-user.jpg") : $program->image ) .'" width="42" height="42" /></div>
                    <div id="InfoProgram">
                        <h3>' . $rst['fromTime'] . ' - ' . $rst['toTime'] . '</h3>';
            $tam = 50;
            if( strlen( $program->description ) > $tam ) {
                echo "<p>" . substr( $program->description, 0, $tam ) . "..." . "</p>";
            } else {
                echo "<p>" . $program->description . "</p>";
            }

            echo '</div>
                  </div>';
        }

        $sql = "select COUNT(id) from {$dbprefix}schedule where day = '{$day}'";

        $r = mysql_fetch_array( $con->make_request($sql), MYSQL_NUM );

        $total = ceil( ( $r[0] ) / 12 );

        echo '<div id="Paginador">';
        if( $offset > 0 ) {
            echo '<a style="cursor: pointer;" onclick="$(\'#' . $day . '\').load(\'' . modules_url . 'schedule/main.php?day=' . $day . '&offset=' . ( $offset - 1 ) . '\');"> < Anterior</a>';
            echo ' | ';
        }
        if( $offset < ( $total - 1 ) ) {
            echo '<a style="cursor: pointer;" onclick="$(\'#' . $day . '\').load(\'' . modules_url . 'schedule/main.php?day=' . $day . '&offset=' . ( $offset + 1 ) . '\');">Siguiente &gt;</a>';
        }
        echo '</div>';
    } else {
        return false;
    }
}

?>
