<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Returns a GET-parameter.
 * 
 * @param   string      $key        Name of the GET-parameter
 * @param   mixed       $default    Default value, if $key is not found.
 * @return  mixed
 */
function __get($key, $default = '') {
    return (
        array_key_exists($key, $_GET) ? $_GET[$key] : $default
    );
}
