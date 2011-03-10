<?php

require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

$action = $_POST['action'];
if (empty($action))
    $action = $_GET['action'];

switch( $action ) {
    case "install":
        $path = $_POST['path'];
        $base_path = base_dir . 'plugins/' . $path . '/';

        include( $base_path . '/install.php' );

        include( $base_path . '/description.php' );
        
        add_plugin($invoke_name, $path, $version);

        echo json_encode( array("response" => true) );
        break;
    case "uninstall":
        $pid = $_POST['id'];
        $plugin = new Plugin( $pid );

        $base_path = base_dir . 'plugins/' . $plugin->path . '/';

        include( $base_path . '/uninstall.php' );

        $plugin->delete();

        echo json_encode( array("response" => true ) );
        break;
}
?>
