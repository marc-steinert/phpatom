<?php
/**
 * Escapes HTML characters in UTF-8
 *
 * @param string|array $input
 * @return string
 */
function __html($input) {
    $escaped = null;
    
    if (is_array($input)) {
        array_walk($input, create_function('&$key, &$value', '$key = __html($key); $value = __html($value);'));
        
        $escaped = $input;
    } else {
        $escaped = htmlspecialchars($input, ENT_COMPAT, 'UTF-8');
    }
    
    return $escaped;
}
