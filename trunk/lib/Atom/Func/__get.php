<?php

function __get($key, $default = 0) {
    return (
        array_key_exists($key, $_GET) ? $_GET[$key] : $default
    );
}
