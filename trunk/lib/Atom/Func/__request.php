<?php

function __request($key, $default = '') {
    if (array_key_exists($key, $_REQUEST)) {
        return $_REQUEST[$key];
    }

    return $default;
}