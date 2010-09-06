<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Defines standard way to convert objects to a string representation,
 *  which is useable in SQL queries.
 * 
 */
interface Atom_Db_ISQLValue {
    
    /**
     * Returns a represention of an object for use in a SQL query.
     * 
     * @return  string
     */
    function toSql();
}