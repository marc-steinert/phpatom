<?php

function __post($key, $default = 0) {
    return (
        array_key_exists($key, $_POST) ? $_POST[$key] : $default
    );
}
