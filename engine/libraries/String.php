<?php

class String {

    static function strparse( $text ) {
        $normalize = array(
                "á" => "&aacute;",
                "Á" => "&Aacute;",
                "é" => "&eacute;",
                "É" => "&Eacute;",
                "í" => "&iacute;",
                "Í" => "&Iacute;",
                "ó" => "&oacute;",
                "Ó" => "&Oacute;",
                "ú" => "&uacute;",
                "Ú" => "&Uacute;",
                "ñ" => "&ntilde;",
                "Ñ" => "&Ntilde;"
        );

        return srt_replace( keys( $normalize ), values( $normalize ), $text );
    }

}
?>
