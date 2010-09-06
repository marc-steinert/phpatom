<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Returns a POST-parameter.
 * 
 * @param   string      $key        Name of the POST-parameter
 * @param   mixed       $default    Default value, if $key is not found.
 * @return  mixed
 */
function __post($key, $default = 0) {
    return (
        array_key_exists($key, $_POST) ? $_POST[$key] : $default
    );
}
