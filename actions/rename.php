<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$filename = $_POST['filename'];
$old = $_POST['old'];

if( strpos( $old, base_url ) ) {
    unlink( $old );
}

$user = check_session();

$time = date('His');

$name = $user->uid . "_" . $time;

rename( base_dir . "pictures/" .  $filename , base_dir . "pictures/" . $name . ".jpg" );

echo base_url . "pictures/" . $name . ".jpg";

?>
