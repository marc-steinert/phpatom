<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Adapter for storage systems useable by the atom framework.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Storage_IAdapter {
    
    /**
     * 
     * 
     * @param   mixed   $key
     */
    public function get($class, $key);
    
    /**
     * 
     * 
     * @param   mixed   $key
     * @param   string  $path
     */
    public function save($class, $key, $path);
    
    /**
     * 
     * 
     * @param   mixed   $key
     */
    public function delete($class, $key);
    
    /**
     * 
     * 
     * @param   mixed   $key
     * @return  bool
     */
    public function exists($class, $key);
}