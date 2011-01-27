<?php
/**
 * Translates text.
 * 
 * @uses    Atom_Translate
 * 
 * @param   string      $text
 * @param   array|null  $substitution
 * @return  string
 */
function __($text, $substitution = null) {
    return Atom_Translate::instance()->translateString($text, $substitution);
}