<?php

function cameltize($name) {
    $name = ucfirst(strtolower($name));
    $name = str_replace(
        array('-', '_', '.'),
        ' ',
        $name
    );
    $name = ucwords($name);
    $name = str_replace(' ', '', $name);
    
    return $name;
}