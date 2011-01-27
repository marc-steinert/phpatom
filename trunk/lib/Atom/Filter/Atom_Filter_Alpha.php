<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Filter for removing non character input.
 * 
 * @uses        Atom_ArgumentException
 * @uses        Atom_Filter_Interface
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Filter_Alpha implements Atom_Filter_Interface {
    
    /** @var bool */
    protected $_allowWhitespace;
    
    /** @var bool */
    protected $_usePlainAscii;
    
    /** @var bool */
    protected static $_unicodeEnabled = null;
    
    
    /**
     * 
     * 
     * @param   bool    $allowWhitespace    Keep whitespaces?
     * @param   bool    $usePlainAscii      Remove non ascii characters?
     * @return  Atom_Filter_Alpha
     */
    public function __construct($allowWhitespace = false, $usePlainAscii = false) {
        $this->_allowWhitespace = (bool) $allowWhitespace;
        $this->_usePlainAscii = (bool) $usePlainAscii;
        
        if (self::$_unicodeEnabled === null) {
            // Pruefe, ob Unicode unterstuetzt wird
            self::$_unicodeEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;
        }
    }

// {{{ Atom_Filter_Interface implementation
    public function filter($value) {
        $whiteSpace = $this->_allowWhitespace ? '\s' : '';
        $pattern = '';
        
        if (!self::$_unicodeEnabled || $this->_usePlainAscii) {
            $pattern = '/[^a-zA-Z'.$whiteSpace.']/';
        } else {
            $pattern = '/[^\p{L}'.$whiteSpace.']/u';
        }
        
        return preg_replace($pattern, '', (string) $value);
    }
// }}}
}
