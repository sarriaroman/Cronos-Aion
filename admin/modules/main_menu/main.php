<?php

function getSelected($div){
    echo ($div == $_REQUEST['section']) ? "active" : "";
}
?>
