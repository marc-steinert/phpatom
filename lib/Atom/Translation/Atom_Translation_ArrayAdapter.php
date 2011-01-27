<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * 
 *
 * @uses        Atom_Translation_IAdapter
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Translation_ArrayAdapter implements Atom_Translation_IAdapter {
    
    /** @var array */
    private $_translations;
    
    
    public function __construct(array $translations) {
        $this->_translations = $translations;    
    }
    
    public function getTranslation($string) {
        if (array_key_exists($string, $this->_translations)) {
            return $this->_translations[$string];
        }
        
        return '';
    }
}
