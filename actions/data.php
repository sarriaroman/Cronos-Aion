<?php

    require_once( dirname(dirname(__FILE__)) . "/engine/start.php" );

    if( ( $user = check_session() ) ) {
        $user->name = $_POST["name"];
        $user->company = $_POST["company"];
        $user->position = $_POST["position"];
        $user->email = $_POST["email"];
        $user->description = $_POST["description"];
        $user->telephone = $_POST["telephone"];
        $user->website = $_POST["website"];

        $user->image = $_POST["image"];


        if( !( $user->save() ) ) {
            echo "<font color=\"green\">Los datos fueron guardados.</font>";
        } else {
            echo "<font color=\"red\">Hubo un error al guardar los datos.</font>";
        }
    }

?>
