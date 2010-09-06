<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Defines database table association of an object
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Db_IModel {
    
    /**
     * Returns the database table name
     * 
     * @return   string
     */
    static function getTableName();
    
    /**
     * Returns the primary key name
     * 
     * @return   string
     */
    static function getPrimaryName();
}
