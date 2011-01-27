<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Singleton that represents the HTTP request, the user has
 *  made to access the script.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_HttpRequest {

    /** @var Atom_HttpRequest */
    private static $_instance = null;

    /** @var array */
    private $_url;


    private function __construct() {
        $this->_url = parse_url($_SERVER['REQUEST_URI']);
    }

    /**
     * Singleton accessor
     *
     * @return  Atom_HttpRequest
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Returns the URI path.
     *
     * @return  string
     */
    public function getPath() {
        return __getArrayValue($this->_url, 'path');
    }
    
    /**
     * @return   string
     */
    public function getQuery() {
        return __getArrayValue($this->_url, 'query');
    }
}