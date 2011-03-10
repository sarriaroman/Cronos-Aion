<?php

function loadPlugins() {
    $directory = base_dir . 'plugins/';

    $dirs = get_directories_in_directory( $directory );

    foreach ($dirs as $dir) {
        include( $directory . $dir . '/description.php' );
        
        echo '<tr>
            <td>' . $name . '</td>
            <td class="action">';
        if( ( $plugin = Plugin::getByPath( $dir ) ) ) {
            echo '<span class="delete" onclick="uninstallPlugin(' . $plugin->id . ');">uninstall</span>';
        } else {
            echo '<span class="view" onclick="installPlugin(\'' . $dir . '\');">install</span>';
        }
        echo'</td>
        </tr>';
        echo '<tr class="odd">
            <td>' . $description . '</td>
            <td class="action">';
        echo '<span class="edit">v' . $version . '</span>';
        echo '</td>';
        echo '</tr>';
    }
}

function loadPluginSettings() {
    global $dbprefix;
    $directory = base_dir . 'plugins/';
    $con = new Connection();

    $response = $con->make_request("select id from {$dbprefix}plugins;");

    if( mysql_num_rows($response) == 0 ) {
        echo '<li><span id="head">None</span></li>';
    }

    while( ( $resp = mysql_fetch_object($response) ) ) {
        $plugin = new Plugin( $resp->id );
        if( ( $sections = get_plugin_admin_sections( $plugin->invoke_name ) ) ) {
            include( $directory . $plugin->path . '/description.php' );
            
            echo '<li><span> &raquo; ' . $name . '</span></li>';
            
            foreach( $sections as $section ) {
                echo '<li><a href="' . urldecode( $section['url'] ) . '">' . $section['label'] . '</a></li>';
            }
        }
    }
}

?>
