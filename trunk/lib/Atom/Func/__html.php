<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Escapes HTML characters in UTF-8
 *
 * @param   string    $input
 * @return  string
 */
function __html($input) {
    $escaped = null;
    
    if (is_array($input)) {
        array_walk($input, create_function('&$key, &$value', '__html($key); __html($value);'));
        
        $escaped = $input;
    } else {
        $escaped = htmlspecialchars($input, ENT_COMPAT, 'UTF-8');
    }
    
    return $escaped;
}
