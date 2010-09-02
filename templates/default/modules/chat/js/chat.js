/* 
 * JavaScript para manejar los datos en el chat
 */

var modules = "";
var refresh;

function init( m, r ) {
    modules = m;
    refresh = r;
};

function reload() {

    return setInterval(function()
    {
        $("#loadingimage").show();

        var last = $("#last").val();

        $.post( modules + "chat/chat.php" ,
        {
            action: "reload",
            last: last
        },

        // Función que se invoca al terminar el script PHP correctamente.
        function( data ) {
            if( data.last == -1 ) {
                $("#loadingimage").hide();
                return false;
            }

            $("#chat").append( data.text );

            scrollBottom();

            $("#last").val( data.last );

            $("#loadingimage").hide();
        }, "json"
    );
    }, ( refresh * (1000) ) );
};

function scrollBottom() {
    $("#chat").animate({ 
        scrollTop: $("#chat").attr("scrollHeight")
    }, "slow");

    document.title = "..:: CVC Chat Online ::.. - Hay nuevos mensajes";
};

$(function() {
    var interval;

    $("#loadingimage").show();
    $.post( modules + "chat/chat.php" ,
    {
        action: "load"
    },

    // Función que se invoca al terminar el script PHP correctamente.
    function( data ) {
        $("#chat").append( data.text );

        scrollBottom();

        $("#last").val( data.last );
        $("#loadingimage").hide();
    }, "json"
);

    interval = reload();

    $("#send").click(function() {
        $("#loadingimage").show();
        clearInterval( interval );

        var name = $("input#name").val();
        var image = $("img#posterphoto").attr("src");
        var message = $("textarea#message").val();
        var fblink = $("input#fblink").val();

        if( fblink != "" && fblink != "undefined" ) {
            name = "<a href='" + fblink + "'>" + name + "</a>";
        }

        if( name == "" ) {
            $("input#name").animate({
                backgroundColor: "red"
            }, "slow");
            setTimeout(function(){
                $("input#name").animate({
                    backgroundColor: "white"
                }, "slow");
            }, 2000);

            interval = reload();
            $("#loadingimage").hide();
            return false;
        }

        if( message == "" ) {
            $("textarea#message").animate({
                backgroundColor: "red"
            }, "slow");
            setTimeout(function(){
                $("textarea#message").animate({
                    backgroundColor: "white"
                }, "slow");
            }, 2000);

            interval = reload();
            $("#loadingimage").hide();
            return false;
        }

        // Aca deberia ir el envio de datos al php que lo inserta en la base de datos.
        $.post( modules + "chat/chat.php" ,
        {
            action: "add",
            name: name,
            image: image,
            message: message
        },

        // Función que se invoca al terminar el script PHP correctamente.
        function( html ) {
            if( html.indexOf("true") != -1 ) {
                $.post( modules + "chat/chat.php" , { action: "reload", last: $("#last").val() },
                function( data ) {
                    try {
                        if( data.last == -1 ) return false;

                        $("#chat").slideDown("slow").append( data.text );

                        scrollBottom();

                        $("#last").val( data.last );
                    } catch(err) {
                        $("#loadingimage").hide();
                    }
                }, "json" );
            }

            interval = reload();

            $("textarea#message").val("");
            $("#loadingimage").hide();
        }
    );
    });

    $("textarea#message").keypress(function (e) {
        if (e.which == 13 ) {
            $("#loadingimage").show();
            clearInterval( interval );

            var name = $("input#name").val();
            var image = $("img#posterphoto").attr("src");
            var message = $("textarea#message").val();
            var fblink = $("input#fblink").val();

            if( fblink != "" && fblink != "undefined" ) {
                name = "<a href='" + fblink + "'>" + name + "</a>";
            }

            if( name == "" ) {
                $("input#name").animate({
                    backgroundColor: "red"
                }, "slow");
                setTimeout(function(){
                    $("input#name").animate({
                        backgroundColor: "white"
                    }, "slow");
                }, 2000);

                interval = reload();
                $("#loadingimage").hide();
                return false;
            }

            if( message == "" ) {
                $("textarea#message").animate({
                    backgroundColor: "red"
                }, "slow");
                setTimeout(function(){
                    $("textarea#message").animate({
                        backgroundColor: "white"
                    }, "slow");
                }, 2000);

                interval = reload();
                $("#loadingimage").hide();
                return false;
            }

            // Aca deberia ir el envio de datos al php que lo inserta en la base de datos.
            $.post( modules + "chat/chat.php" ,
            {
                action: "add",
                name: name,
                image: image,
                message: message
            },

            // Función que se invoca al terminar el script PHP correctamente.
            function( html ) {
                if( html.indexOf("true") != -1 ) {
                    $.post( modules + "chat/chat.php" , { action: "reload", last: $("#last").val() },
                    function( data ) {
                        try {
                            if( data.last == -1 ) return false;

                            $("#chat").slideDown("slow").append( data.text );

                            scrollBottom();

                            $("#last").val( data.last );
                        } catch(err) {
                            $("#loadingimage").hide();
                        }
                    }, "json" );
                }

                interval = reload();

                $("textarea#message").val("");
                $("#loadingimage").hide();
            }
        );
        }
    });

    $(window).focus(function(){
        setTimeout(function(){
            document.title = "..:: CVC Chat Online ::..";
        }, 3000);
    });
});


