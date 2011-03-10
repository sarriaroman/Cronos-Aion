<?php

function loadOperations() {
    $operations = Operations::getOperationbyUser($_REQUEST['id']);

    $v = true;
    while( $op = mysql_fetch_object($operations) ) {
        $type = new OpTypes($op->optype);
        echo ( $v ) ? '<tr class="odd">' : '<tr>';

        echo    '<td><span style="color:red;"><strong>' . $op->created . ' ('.$type->name.')</strong></span>';
        echo        '<ul id="info_'. $op->id.'" style="background-color: #F6F6; width: 400px;"><pre style="width: 400px;">'. $op->value .'</pre></ul>';
        echo    '</td>';
        echo    '<td class="action">';
        if($op->debit!=0)
            echo        "<span> +". $op->debit."</span>";
        if($op->credit!=0)
            echo        "<span> -". $op->credit."</span>";
        echo    '</td>';
        echo "</tr>";
        $v = !$v;
    }
}

?>