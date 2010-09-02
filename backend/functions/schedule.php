<?php


function loadSchedule() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, progid, fromTime, toTime, day from {$dbprefix}schedule";

    $req = $con->make_request($sql);

    while( $schedule = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        $program = new Program( $schedule['progid'] );

        $text = $program->name . ": " . get_message( "week:" . strtolower( $schedule['day'] ) ) . " (" . $schedule['fromTime'] . " - " . $schedule['toTime'] . ')';

	echo '<h3 class="ui-widget-header ui-corner-all"><span id="s' . $schedule['id'] . '">' . $text . '</span>';

        echo '<a onclick="deleteSchedule(' . $schedule['id'] . ', \'' . $text . '\');" title="Borrar horario" style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;"><img src="' . base_url . 'backend/imgs/cross.png" /></a>';

        echo '<a style="font-size: 10px; cursor: pointer; float: right; margin-right: 5px;" title="Modificar horario" onclick="if( $(\'#schedule-' . $schedule['id'] . '\').css(\'display\') != \'none\'){
                                                    $(\'#schedule-' . $schedule['id'] . '\').hide();
                                                }else{
                                                    $(\'#schedule-' . $schedule['id'] . '\').show();
                                                }"><img src="' . base_url . 'backend/imgs/page_edit.png" /></a>';

        echo '</h3>';

        echo '<div id="schedule-' . $schedule['id'] . '" style="display: none;">';
        echo '<script type="text/javascript">
        $(function(){

            $("#cbsprograms' . $schedule['id'] . ' option[value=' . $schedule['progid'] . ']").attr("selected", "selected");
            $("#cbschedule' . $schedule['id'] . ' option[value=' . $schedule['day'] . ']").attr("selected", "selected");

            $("#saveschedule' . $schedule['id'] . '").click( function(){

                var url_send = "' . actions_url . 'admin.php";

                var pid = $("#cbsprograms' . $schedule['id'] . '").val();
                var name = $("#cbsprograms' . $schedule['id'] . ' option:selected").text();
                var from = $("input#sfrom' . $schedule['id'] . '").val();
                var to = $("input#sto' . $schedule['id'] . '").val();
                var day =  $("#cbschedule' . $schedule['id'] . '").val();

                if( pid == "" || from == "" || to == "" ) {
                    $("#sresponse' . $schedule['id'] . '").fadeIn("slow");
                    $("#sresponse' . $schedule['id'] . '").text("Faltan completar campos");

                    setTimeout(function() {
                        $("#sresponse' . $schedule['id'] . '").fadeOut("slow");
                    }, 2000);

                    return false;
                }

                var vars = "action=editschedule&pid=" + pid + "&from=" + from + "&to=" + to + "&day=" + day + "&sid=' . $schedule['id'] . '&name=" + name;
                $.ajax({
                    type: "POST",
                    url: url_send,
                    data: vars,
                    success: function(html) {
                        $("#sresponse' . $schedule['id'] . '").fadeIn("slow");
                        $("#sresponse' . $schedule['id'] . '").html(html);

                        setTimeout(function() {
                            $("#sresponse' . $schedule['id'] . '").fadeOut("slow");
                        }, 2000);

                        if( html.indexOf("error") == -1 ) {
                            $("#schedule-' . $schedule['id'] . '").hide();
                            $("#s' . $schedule['id'] . '").html(html);
                        }

                    }
                });
                return false;
            });

        });
    </script>
    
    Programa: <select id="cbsprograms' . $schedule['id'] . '" >';
    loadProgramsSchedule();
    echo '</select>';
    echo '<br/>Desde: <input name="textfield" type="text" id="sfrom' . $schedule['id'] . '" class="text ui-widget-content ui-corner-all" size="100" value="' . $schedule['fromTime'] . '" />
    <br />Hasta: <input name="textfield" type="text" id="sto' . $schedule['id'] . '" class="text ui-widget-content ui-corner-all" size="100" value="' . $schedule['toTime'] . '" />
    <br />
    <select id="cbschedule' . $schedule['id'] . '" >
        <option value="monday">Lunes</option>
        <option value="tuesday">Martes</option>
        <option value="wednesday">Miercoles</option>
        <option value="thursday">Jueves</option>
        <option value="friday">Viernes</option>
        <option value="saturday">Sabado</option>
        <option value="sunday">Domingo</option>
    </select>
    <div id="sresponse' . $schedule['id'] . '"></div>
    <br /><input type="submit" id="saveschedule' . $schedule['id'] . '" value="Guardar" class="ui-button ui-state-default ui-corner-all" />';
    echo "</div>";

    }
}

function loadProgramsSchedule() {
    global $dbprefix;

    $con = new Connection();

    $sql = "select id, name from {$dbprefix}programs";

    $req = $con->make_request($sql);

    while( $user = mysql_fetch_array( $req, MYSQL_ASSOC ) ) {
        echo '<option value="' . $user['id'] . '">' . $user['name'] . '</option>';
    }
}

?>
