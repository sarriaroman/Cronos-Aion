<?php admin_module("header"); ?>

<script type="text/javascript">
            $(function() {

                $("#data").submit( function(){
                    var url_send = "<?php echo actions_url; ?>admin.php";

                    var mail = $("input#name").val();

                    var vars = "action=restorekey&email=" + mail;
                    $.ajax({
                        type: "POST",
                        url: url_send,
                        data: vars,
                        success: function(html) {
                            if( html.indexOf("<login: ok>") != -1 ) {
                                window.location.href = "<?php echo base_url; ?>admin.php";
                            } else {
                                $("#response").fadeIn('slow');
                                $("#response").html(html);
                            }
                            setTimeout(function() {
                                $("#response").fadeOut('slow');
                            }, 2000);
                        }
                    });
                    return false;
                });

                $('#return').click(function(){
                    window.location = "<?php echo base_url; ?>admin.php";

                    return false;
                });
            });
        </script>

    <!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
    <div id="logo"><a href="#"><span>Cronos {Admin Panel}</span></a></div>

    <!-- You can name the links with lowercase, they will be transformed to uppercase by CSS, we prefered to name them with uppercase to have the same effect with disabled stylesheet -->
    <ul id="mainNav">
        <li><a href="#" class="active">Restaurar contraseña</a></li> <!-- Use the "active" class for the active menu item  -->
    </ul>
    <!-- // #end mainNav -->

    <div id="containerHolder">
        <div id="container">
            <div id="sidebar">
                <ul class="sideNav">
                    <li><a href="#" class="active">Restaure</a></li>
                </ul>
                <!-- // .sideNav -->
            </div>
            <!-- // #sidebar -->

            <div id="main">
                <form id="data" method="post" class="jNice">
                    <h3>Restaure su clave</h3>
                    <div id="response"></div>
                    <fieldset>
                        <p><label>Usuario o e-mail:</label><input type="text" class="text-long" id="name" /></p>
                        <input type="submit" value="Restaurar" id="login" />
                        <input type="submit" value="Regresar" id="return" />
                    </fieldset>
                </form>
            </div>
            <!-- // #main -->

            <div class="clear"></div>
        </div>
        <!-- // #container -->
    </div>
    <!-- // #containerHolder -->
<?php admin_module("footer"); ?>
