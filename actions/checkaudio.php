<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$filename = $_POST['filename'];

$file = base_dir . "podcast/" . $filename;

$m = new mp3file( $file );
$a = $m->get_metadata();

if ($a['Encoding']=='Unknown') {
    unlink( $file );

    header('Content-type: application/json');

    $arr = array( "error" => "yes", "message" => "<strong>Se produjo un error al subir el archivo:</strong><br /> - Codificación no válida.<br /> - Formato no válido." );

    echo json_encode($arr);

    return;
} else {
    $output = $a['Length mm:ss'];

    $filename = $_POST['filename'];
    $user = check_session();

    $file = base_dir . "podcast/" . $filename;

    $pid = Podcast::podcast_count( $user->uid );

    $nfn = $user->uid . $pid . ".mp3";

    $newname = base_dir . "podcast/" . $nfn ;

    rename( $file , $newname );
}

unset($a);

$time = explode(":", $output);

if( $time[0] <= 60 ) {
    header('Content-type: application/json');
    
    $arr = array( "error" => "no", 
                  "time" => ( "00:" . ( ( strlen($time[0]) == 1 ) ? "0" . $time[0] : $time[0] ) . ":" . ( ( strlen($time[1]) == 1 ) ? "0" . $time[1] : $time[1] ) ),
                  "url" => ( base_url . "podcast/" . $nfn ) );

    echo json_encode($arr);
}

?>
