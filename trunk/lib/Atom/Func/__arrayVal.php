<?php
/**
 * 
 * 
 * @param   mixed   $array
 * @param   mixed   $key
 * @param   mixed   $default
 * @return  bool
 */
function __arrayVal(array $array, $key, $default = '') {
    return (
        array_key_exists($key, $array) ? $array[$key] : $default
    );
}
