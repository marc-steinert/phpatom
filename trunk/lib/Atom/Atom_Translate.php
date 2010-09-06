<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Translation classe
 * 
 * @note        This class is a stub and doesn't actually translate anything.
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Translate {

    private function __construct() { }

    /**
     * Singleton accessor
     *
     * @return  Atom_Translate
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @todo    considering, this is a very important and often called
     *          function, a bit of optimization would be great.
     * 
     * @todo    Implement real translation voodoo.
     * 
     * @note    This method is a stub and doesn't translate anything
     *
     * @return  string
     */
    public function translateString($text, $substitution = null) {
        return str_replace(
            array_keys($substitution),
            array_values($substitution),
            $text
        );
    }
}
