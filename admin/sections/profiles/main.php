<?php admin_module("header"); ?>

<!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
<div id="logo"><a href="#"><span>Cronos {Admin Panel}</span></a></div>

<!-- You can name the links with lowercase, they will be transformed to uppercase by CSS, we prefered to name them with uppercase to have the same effect with disabled stylesheet -->
<ul id="mainNav">
    <li><a href="<?php echo base_url; ?>admin.php?section=home">Inicio</a></li> <!-- Use the "active" class for the active menu item  -->
    <li><a href="<?php echo base_url; ?>admin.php?section=profiles" class="active">Perfiles</a></li>

    <li class="logout"><a href="<?php echo actions_url; ?>admin.php?action=logout">Salir</a></li>
    <li class="logout"><a href="<?php echo base_url; ?>" target="_BLANK">Ver sitio</a></li>
</ul>
<!-- // #end mainNav -->

<div id="containerHolder">
    <div id="container">

        <?php
        if( isset ($_GET['module']) ) {
            admin_module("profiles-" . $_GET['module'] );
        } else {
            admin_module("profiles-add" );
        }
        ?>

        <div class="spacer"></div>

        <div class="clear"></div>
    </div>
    <!-- // #container -->
</div>
<!-- // #containerHolder -->

<?php admin_module("footer"); ?>