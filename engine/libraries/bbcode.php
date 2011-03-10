<?php

function bbcode_format($str) {
    //$str = htmlentities($str);

    $simple_search = array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[url\=(.*?)\](.*?)\[\/url\]/is',
            '/\[url\](.*?)\[\/url\]/is',
            '/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
            '/\[img\](.*?)\[\/img\]/is',
            '/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
            '/\[mail\](.*?)\[\/mail\]/is',
            '/\[font\=(.*?)\](.*?)\[\/font\]/is',
            '/\[size\=(.*?)\](.*?)\[\/size\]/is',
            '/\[color\=(.*?)\](.*?)\[\/color\]/is',
            '/\[c\=(.*?)\](.*?)\[\/c\]/is',
            '/\[thumb\=(.*?)\](.*?)\[\/thumb\]/is',
            '/\[strike\](.*?)\[\/strike\]/is',
            '/\[br\]/is',
            '/\[imglink\=(.*?)\](.*?)\[\/imglink\]/is',
    );

    $simple_replace = array(
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<a href=\'$1\' target=\'_blank\'>$2</a>',
            '<a href=\'$1\' target=\'_blank\'>$1</a>',
            '<div style=\'text-align: $1;\'>$2</div>',
            '<img src=\'$1\' alt=\'Picture\' border=\'0\'/>',
            '<a href=\'mailto:$1\'>$2</a>',
            '<a href=\'mailto:$1\'>$1</a>',
            '<span style=\'font-family: $1;\'>$2</span>',
            '<span style=\'font-size: $1px;\'>$2</span>',
            '<span style=\'color: $1;\'>$2</span>',
            '<span style=\'color: $1;\'>$2</span>',
            '<img width=\'$1\' src=\'$2\' alt=\'Picture\' border=\'0\'/>',
            '<span style=\'text-decoration: line-through;\'>$1</span>',
            '<br />',
            '<a href=\'$1\'><img src=\'$2\' alt=\'Picture\' border=\'0\' /></a>',
    );

    // Do simple BBCode's
    $str = preg_replace ($simple_search, $simple_replace, $str);

    return $str;
}

?>
