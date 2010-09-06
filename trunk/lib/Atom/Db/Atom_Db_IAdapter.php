<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Adapter interface for database access.
 * 
 * @note    Every database adapter has to implement this interface.
 */
interface Atom_Db_IAdapter {
    
    /**
     * Takes and executes a database query.
     * 
     * @note    This method does _not_ return a result and thus should be
     *  used for UPDATE, DELETE, INSERT queries _only_ which don't yield a
     *  result set.
     * 
     * @param   string  $query
     */
    public function read($query);
    
    /**
     * Takes and executes a database query and returns it's result.
     * 
     * @param   string  $query
     */
    public function write($query);    
}
