<?php admin_module("header"); ?>

<div id="containerHolder">
    <div id="container">

        <?php
        if( isset ($_GET['module']) ) {
            admin_module( $_GET['module'], $_GET['plugin'] );
        } else {
            admin_module( "doc", $_GET['plugin'] );
        }
        ?>

        <div class="spacer"></div>

        <div class="clear"></div>
    </div>
    <!-- // #container -->
</div>
<!-- // #containerHolder -->

<?php admin_module("footer"); ?>