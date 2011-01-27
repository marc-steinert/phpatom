<?php
/**
 * Escapes a string for use in MySQL queries
 *
 * @param   mixed   $input
 * @return  string
 */
function __escape($input) {
    if (is_array($input)) {
        return array_map('__escape', $input);
    } else if (is_object($input) && $input instanceof Atom_Db_ISQLValue) {
        return mysql_real_escape_string($input->toSql());
    }
    
    return mysql_escape_string($input);
}
