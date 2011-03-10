<?php admin_module("header"); ?>

<div id="containerHolder">
    <div id="container">

        <?php
        if( isset ($_GET['module']) ) {
            admin_module( $_GET['section'] . "-" . $_GET['module'] );
        } else {
            if( isset ($_GET['id']) ) {
                admin_module( $_GET['section'] . "_view" );
            } else {
                admin_module( $_GET['section'] . "-add" );
            }
        }
        ?>

        <div class="spacer"></div>

        <div class="clear"></div>
    </div>
    <!-- // #container -->
</div>
<!-- // #containerHolder -->

<?php admin_module("footer"); ?>