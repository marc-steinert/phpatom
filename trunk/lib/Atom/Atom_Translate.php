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
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Translate {

    /** @var Atom_Translate */
    private static $_instance = null;
    
    /** @var Atom_Translation_IAdapter */
    private $_apapter = null;
    
    /** @var array */
    private $_notTranslated = array();
    
    
    private function __construct() { }

    public function __destruct() { }

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
    
    public function setTranslationAdapter(Atom_Translation_IAdapter $adapter) {
        $this->_apapter = $adapter;
    }
    
    public function getNotTranslated() {
        return array_unique($this->_notTranslated);
    }
    
    /**
     * @todo    considering, this is a very important and often called
     *          function, a bit of optimization would be great.
     *
     * @return  string
     */
    public function translateString($text, $substitution = null) {
        if ($this->_apapter === null) {
            if ($substitution === null) {
                return $text;
            } else {
                return str_replace(
                    array_keys($substitution),
                    array_values($substitution),
                    $text
                );
            }
        }
        
        $translated = $this->_apapter->getTranslation($text);

        if (trim($translated) == '') {
            $this->_notTranslated[] = $text;
            $translated = $text;
        }

        if ($substitution !== null) {
            return str_replace(
                array_keys($substitution),
                array_values($substitution),
                $translated
            );
        } else {
            return $translated;
        }
    }

    private static function array_flatten(array $array) {
        $out = array();

        foreach ($array as $curArray) {
            $out[$curArray[0]] = $curArray[1];
        }

        return $out;
    }
}
