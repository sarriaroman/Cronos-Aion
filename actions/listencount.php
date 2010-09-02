<?php
    
    require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

    $pid = $_POST['pid'];

    $podcast = new Podcast($pid);

    $count = $podcast->Listen_count;
    $count++;
    $podcast->Listen_count = $count;

    $podcast->save();

?>
