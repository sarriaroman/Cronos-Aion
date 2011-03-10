<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/


function input( $label, $name, $key ) {
    echo '<script type="text/javascript">';
    echo '$(function(){
                $("#button-' . $name . '").click( function(){

                var url_send = "' . actions_url . 'admin.php";

                var value = $("input#' . $name . '").val();

                if( value == "" ) {
                    $("#response-' . $name . '").fadeIn("slow");
                    $("#response-' . $name . '").text("El campo no debe estar vacio");

                    setTimeout(function() {
                        $("#response-' . $name . '").fadeOut("slow");
                    }, 2000);

                    return false;
                }

                var vars = "action=config&key=' . $key . '&value=" + value;
                $.ajax({
                    type: "POST",
                    url: url_send,
                    data: vars,
                    success: function(html) {
                        $("#response-' . $name . '").fadeIn("slow");
                        $("#response-' . $name . '").text("");
                        $("#response-' . $name . '").append( html );

                        setTimeout(function() {
                            $("#response-' . $name . '").fadeOut("slow");
                        }, 2000);
                    }
                });
                return false;
            });
        });';
    echo "</script>";

    echo '<form class="jNice">';
    echo "<fieldset>";
    echo "<p>";
    echo "<label>" . $label . ":</label>";
    echo '<input name="textfield" type="text" id="' . $name . '" class="text-long" value="' . get_config($key) . '" size="100" /><div id="response-' . $name . '"></div>';
    echo "</p>";
    echo '<input type="submit" id="button-' . $name . '" value="Guardar" />';
    echo '';
    echo "</fieldset>";
    echo "</form>";
}


function textarea( $label, $name, $key, $w ) {
    echo '<script type="text/javascript">';
    echo '$(function(){';

    if( $w ) {
        echo "$(function()
        {
            $('textarea#" . $name . "').wysiwyg();
        });";
    }

    echo '  $("#button-' . $name . '").click( function(){

                var url_send = "' . actions_url . 'admin.php";

                var vvalue = $("textarea#' . $name . '").val();

                if( vvalue == "" ) {
                    $("#response-' . $name . '").fadeIn("slow");
                    $("#response-' . $name . '").text("El campo no debe estar vacio");

                    setTimeout(function() {
                        $("#response-' . $name . '").fadeOut("slow");
                    }, 2000);

                    return false;
                }

                $.post(url_send,
                   {action: "config",
                    key: "' . $key . '",
                    value: vvalue,
                   },

			//return the data
                    function(html) {
                        $("#response-' . $name . '").fadeIn("slow");
                        $("#response-' . $name . '").text("");
                        $("#response-' . $name . '").append( html );

                        setTimeout(function() {
                            $("#response-' . $name . '").fadeOut("slow");
                        }, 2000);
                    }
                );
                return false;
            });
        });';
    echo "</script>";

    echo "<form class='jNice'>";
    echo "<fieldset>";
    echo "<p>";
    echo "<label>" . $label . ":</label>";
    echo '<textarea id="' . $name . '">' . get_config($key) . '</textarea>';
    echo "</p>";
    echo '<div id="response-' . $name . '"></div>';
    echo '<input type="submit" id="button-' . $name . '" value="Guardar" />';
    echo "</fieldset>";
    echo "</form>";
}

?>
