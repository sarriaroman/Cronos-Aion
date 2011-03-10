<?php

/**
 * Provide functions to plugins installation
 * and functionality.
 *
 * @name Library Plugins
 * 
 * @version 0.5.0
 * @author Román A. Sarria
 */

/**
 * Add plugin
 *
 * Add a plugin when install file is executed.
 *
 * @param invoke name
 * @param install path
 * @param version
 */
function add_plugin($invoke_name, $path, $version) {
    $plugin = new Plugin();

    $plugin->invoke_name = $invoke_name;
    $plugin->path = $path;
    $plugin->version = $version;

    return $plugin->save();
}

function remove_plugin($path) {
    $plugin = Plugin::getByPath($path);

    return $plugin->delete();
}

/**
 * Create a database schema for plugin
 *
 * @param <String> $sql
 */
function create_database_schema($sql) {
    $con = new Connection();

    $con->make_request($sql);
}

/**
 * Create a database schema for plugin from file
 *
 * @param <String> $file You must provide the absolute path. Ex: dirname(__FILE__) . '/schema.sql'
 * @return boolean
 */
function create_database_schema_from_file($file) {
    $fh = fopen($file, 'r');
    $sql = fread($fh, filesize($file));
    fclose($fh);

    $sqls = explode(';', $sql);

    $con = new Connection();

    for ($i = 0; $i < ( count($sqls) - 1 ); $i++) {
        $query = $sqls[$i] . ';';
        if ($con->make_request($query)) {
            $finish = true;
        } else {
            $finish = false;
            break;
        }
    }

    return $finish;
}

/**
 * Add a setting for plugin
 *
 * @global <type> $dbprefix
 * @param <String> $key identifier
 * @param <String> $default default value
 * @return <type>
 */
function add_settings($key, $default = '') {
    $con = new Connection();

    $sql = "insert into config (config_key, config_value) VALUES ('{$key}', '{$default}');";

    if ($con->make_request($sql)) {
        return true;
    } else {
        echo json_encode( array( 'response' => false, 'error' => 'Setting key already exist' ) );
        return;
    }
}

function remove_settings($key) {
    $con = new Connection();

    $sql = "delete from config where config_key = '{$key}';";

    if ($con->make_request($sql)) {
        return true;
    } else {
        echo json_encode( array( 'response' => false, 'error' => 'Setting key already exist' ) );
        return;
    }
}

function get_plugin_base_url($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . '/plugins/' . $plg->path . '/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . '/plugins/' . $plg->path . '/';
    }
}

function get_plugin_invoke_url($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . $plg->invoke_name . '/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/';
    }
}

function get_plugin_invoke_url_by_path($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . $plg->invoke_name . '/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/';
    }
}

function get_plugin_section_url_by_name($section, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . $plg->invoke_name . '/' . $section;
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/' . $section;
    }
}

function get_plugin_section_url_by_path($section, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByPath($plugin);

        return base_url . $plg->invoke_name . '/' . $section;
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/' . $section;
    }
}

function get_plugin_admin_section_url_by_path($section, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByPath($plugin);

        return urlencode( base_url . 'admin.php?plugin=' . $plg->invoke_name . '&section=' . $section );
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return urlencode( admin_base_url . '?plugin=' . $plg->invoke_name . '&section=' . $section );
    }
}

function get_plugin_module_url_by_path($section, $module, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByPath($plugin);

        return base_url . $plg->invoke_name . '/' . $section . '/' . $module;
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/' . $section . '/' . $module;
    }
}

function get_plugin_admin_module_url_by_path($section, $module, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByPath($plugin);

        return urlencode( base_url . 'admin.php?plugin=' . $plg->invoke_name . '&section=' . $section . "&module=" . $module );
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return urlencode( admin_base_url . '?plugin=' . $plg->invoke_name . '&section=' . $section . "&module=" . $module );
    }
}

function get_plugin_module_url_by_name($section, $module, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . $plg->invoke_name . '/' . $section . '/' . $module;
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . $plg->invoke_name . '/' . $section . '/' . $module;
    }
}

function get_plugin_admin_module_url_by_name($section, $module, $plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return urlencode( base_url . 'admin.php?plugin=' . $plg->invoke_name . '&section=' . $section . "&module=" . $module );
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return urlencode( admin_base_url . '?plugin=' . $plg->invoke_name . '&section=' . $section . "&module=" . $module );
    }
}

function get_plugin_javascript_url($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . '/plugins/' . $plg->path . '/js/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . '/plugins/' . $plg->path . '/js/';
    }
}

function get_plugin_css_url($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . '/plugins/' . $plg->path . '/style/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . '/plugins/' . $plg->path . '/style/';
    }
}

function get_plugin_images_url($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);

        return base_url . '/plugins/' . $plg->path . '/images/';
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);

        return base_url . '/plugins/' . $plg->path . '/images/';
    }
}

function load_plugin_functions($plugin = false) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);
    }

    $dir = base_dir . '/plugins/' . $plg->path . '/functions/';

    $files = get_files_in_directory($dir);
    foreach ($files as $class_filename) {
        if (!include_once( $dir . $class_filename )) {
            echo "Error cargando la libreria: $class_filename<br />";
        }
    }
}

function get_plugin_sections( $plugin ) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);
    }

    $dir = base_dir . '/plugins/' . $plg->path . '/sections/';

    $array = array();

    $dirs = get_directories_in_directory( $dir );
    foreach ($dirs as $directory) {
        $label = "";
        include( $dir . $directory . '/description.php' );
        array_push($array, array( "label" => ( $label == "" ) ? $directory : $label, "invoke" => $directory, "url" => get_plugin_section_url_by_path($directory, $plg->path) ) );
    }

    return $array;
}

function get_plugin_admin_sections( $plugin ) {
    if ($plugin) {
        $plg = Plugin::getByName($plugin);
    } else {
        $permalink = getPermalink(0);
        $plg = Plugin::getByName($permalink);
    }

    $dir = base_dir . '/plugins/' . $plg->path . '/admin/sections/';

    $array = array();

    $dirs = get_directories_in_directory( $dir );
    foreach ($dirs as $directory) {
        $label = "";
        include( $dir . $directory . '/description.php' );
        array_push($array, array( "label" => ( $label == "" ) ? $directory : $label, "invoke" => $directory, "url" => get_plugin_admin_section_url_by_path($directory, $plg->path) ) );
    }

    return $array;
}

function get_admin_module_dir( $module, $plugin ) {
    if( $plugin == 'main' ) {
        return admin_modules_dir . $module;
    } else {
        $plg = Plugin::getByName($plugin);
        
        return plugins_dir . $plg->path . '/admin/modules/' . $module;
    }
}

function get_admin_section_dir( $module, $plugin ) {
    if( $plugin == 'main' ) {
        return admin_section_dir . $module;
    } else {
        $plg = Plugin::getByName( $plugin );
        return plugins_dir . $plg->path . '/admin/sections/' . $module;
    }
}

function get_module_dir( $module, $plugin ) {
    if( $plugin == 'main' ) {
        return modules_dir . $module;
    } else {
        return plugins_dir . $plugin . '/modules/' . $module;
    }
}

function get_section_dir( $module, $plugin ) {
    if( $plugin == 'main' ) {
        return section_dir . $module;
    } else {
        return plugins_dir . $plugin . '/sections/' . $module;
    }
}

function get_actions_url( $name ) {
    $permalink = getPermalink(0);
    $plg = Plugin::getByName($permalink);

    $file = plugins_url . $plg->path . '/actions/' . $name . '.php';
    if( file_exists( $file ) ) {
        return $file;
    } else {
        return "";
    }
}

?>
