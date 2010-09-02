<?php

function loadAudioblogs() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id from {$dbprefix}programs where admin_uid <> '-1'";

    $rst = $con->make_request( $sql );

    $i = 0;
    while( $prog = mysql_fetch_array( $rst, MYSQL_ASSOC ) ) {
        $program = new Program( $prog['id'] );

        //if( $i == 0 ) echo '<div style="position:relative; float:left; width:680px; margin:0 0 10px 0">';

        if( get_config('blog:showall') == 'no' && $program->blogpost_count == 0 ) continue;

        $tam = 80;
        if( strlen( $program->description ) > $tam ) {
            $description = substr( $program->description, 0, $tam ) . "...";
        } else {
            $description = $program->description;
        }

        if( ($i % 2) == 0 ) include( modules_dir . 'block_audioblogs/programimpar.html' );
        else include( modules_dir . 'block_audioblogs/programcentro.html' );

        if( $i == 2 ) {
          echo '<div style="position:relative; float:left; width:680px; margin:0 0 10px 0"></div>';
            $i = 0;
        } else {
            $i++;
        }
    }

    //if( $i <= 1 ) {
      //  echo '</div>';
    //}
}

?>
