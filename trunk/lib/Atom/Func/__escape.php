<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Escapes a string for use in MySQL queries
 *
 * @param   int|float|string|array   $input
 * @return  string
 */
function __escape($input) {
    return (is_array($input) ?
         array_map('__escape', $input) : mysql_escape_string($input)
    );
}
