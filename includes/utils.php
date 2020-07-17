<?php
namespace WP_Speak;

function set_default($string, $default) {
    if ("" === $string) {
        return $default;
    } else {
        return $string;
    }
}

?>
