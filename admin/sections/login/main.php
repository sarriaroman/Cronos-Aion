<?php admin_module("header"); ?>

<script type="text/javascript">
            $(function() {
                $("#data").submit(function(){
                    var url_send = "<?php echo actions_url; ?>admin.php";

                    var mail = $("input#name").val();
                    var psw = $("input#password").val();

                    var vars = "action=login&email=" + mail + "&psw=" + psw;
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
            });
        </script>

    <!-- You can name the links with lowercase, they will be transformed to uppercase by CSS, we prefered to name them with uppercase to have the same effect with disabled stylesheet -->
    <ul id="mainNav">
        <li><a href="#" class="active">LOG-IN</a></li> <!-- Use the "active" class for the active menu item  -->
    </ul>
    <!-- // #end mainNav -->

    <div id="containerHolder">
        <div id="container">
            <div id="sidebar">
                <ul class="sideNav">
                    <li><a href="#" class="active">Ingreso</a></li>
                </ul>
                <!-- // .sideNav -->
            </div>
            <!-- // #sidebar -->

            <div id="main">
                <form id="data" method="post" class="jNice">
                    <h3>Ingreso al Panel</h3>
                    <div id="response"></div>
                    <fieldset>
                        <a href="<?php echo base_url; ?>admin.php?section=restore" style="text-decoration: none; color: #CCCCCC;position: relative; float: right; right: 5px;">Restaurar contraseña</a>
                        <p><label>Usuario:</label><input type="text" class="text-long" id="name" /></p>
                        <p><label>Contraseña:</label><input type="password" class="text-long" id="password" /></p>
                        <input type="submit" value="Ingresar" id="login" />
                    </fieldset>
                </form>
                
                <br/>
            </div>
            <!-- // #main -->

            <div class="clear"></div>
        </div>
        <!-- // #container -->
    </div>
    <!-- // #containerHolder -->
<?php admin_module("footer"); ?>
