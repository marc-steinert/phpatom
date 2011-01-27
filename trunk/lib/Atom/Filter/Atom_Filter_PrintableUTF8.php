<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Filter for removing non printable UTF8 input.
 * 
 * @uses        Atom_ArgumentException
 * @uses        Atom_Filter_Interface
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Filter_PrintableUTF8 implements Atom_Filter_Interface {

    public function __construct() { }

// {{{ Atom_Filter_Interface implementation
    public function filter($value) {
        return preg_replace('/\p{Cc}+/u', '', $value);
    }
// }}}
}
