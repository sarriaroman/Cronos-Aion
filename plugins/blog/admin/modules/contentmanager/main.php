<?php

function loadTags() {
    /*$posts = Post::getAll();
    $v = true;

    while( $tag = mysql_fetch_object($posts) ) {
        if( $v ) echo '<tr class="odd">';
        else echo "<tr>";
        
        echo    '<td>';
        //echo        '<ul><strong><span id="info_input_'.$tag->id. '">'.strftime('%Y-%B-%d %H:%M', strtotime($tag->created)).' '.$tag->title.'</span></strong></ul>';
        echo        '<ul><span id="input_'.$tag->id. '" style="display: ;" ><input id="in_'.$tag->id. '" style="width: 100%;" type="text" value="'.$tag->title. '" /></span></ul>';
        
        //echo        '<ul><span id="info_txta_'.$tag->id. '">'.$tag->content. '</span></ul>';
        echo        '<ul><span id="txta_'.$tag->id. '" style="display: ;"><textarea id="tx_'.$tag->id. '" style="height: 200px; width: 100%;" >'.$tag->content. '</textarea></span></ul>';
        echo    '</td>';
        
        echo    '<td class="action">';
        //echo        "<span id='btn_edi_".$tag->id. "' class='view' onclick='editPost(".$tag->id.");' style='cursor: pointer;'>Editar</span>";
        echo        "<span id='btn_sav_".$tag->id. "' class='view' onclick='save(".$tag->id.");' style='display: ; cursor: pointer;'>Guardar</span>";
        echo    '</td>';
        echo "</tr>";
        $v = !$v;
    }

    if( mysql_num_rows( $posts ) == 0 ) echo "no hay post";
     */
}

?>
