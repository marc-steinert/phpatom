<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Gets thrown if framework parts are used other than intended.
 *
 * @uses        Atom_Exception
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Loader {
    
    private function __construct() { }
    
    /**
     * 
     *
     * @param string $className
     * @return bool
     */
    public static function load($className) {
        $classNameParts = explode('_', $className);
        array_pop($classNameParts);

        $filePath =
            ROOT_DIR.'lib/'.implode('/', $classNameParts).'/'.$className.'.php';

        if (file_exists($filePath)) {
            include($filePath);
            return true;
        }

        return false;
    }
}
