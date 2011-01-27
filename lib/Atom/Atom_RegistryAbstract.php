<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Abstract implementation of the registry pattern.
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
abstract class Atom_RegistryAbstract {
    
    /**
     * 
     * 
     * @var string
     */
    private static $_data = array();
    
    
    private final function __construct() { }
    
    /**
     * 
     * 
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value) {
        if (!isset(self::$_data[$key])) {
            self::$_data[$key] = $value;
        } else {
            throw new Atom_ArgumentException();
        }
    }
    
    /**
     * 
     * 
     * @param mixed $key
     * @return Atom_RegistryAbstract
     */
    public static function get($key) {
        if (isset(self::$_data[$key])) {
            return self::$_data[$key];
        }
        
        return null;
    }
    
    /**
     * Removes all data from the registry.
     * 
     */
    public static function clear() {
        self::$_data = array();
    }
    
    /**
     * 
     * 
     * @param mixed $key
     */
    public static function remove($key) {
        if (isset(self::$_data[$key])) {
            unset(self::$_data[$key]);
        }
    }
    
    /**
     * 
     * 
     * @param mixed $key
     * @return Atom_RegistryAbstract
     */
    public static function keyExistst($key) {
        return isset(self::$_data[$key]);
    }
}
