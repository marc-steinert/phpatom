<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Translates text.
 * 
 * @note    This function is only a shortcut for Atom_Translate::translateString()
 * 
 * @uses    Atom_Translate
 * @param   string      $text
 * @param   array|null  $substitution
 * @return  string
 */
function __($text, $substitution = null) {
    return Atom_Translate::instance()
                ->translateString($text, $substitution);
}