<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Defines how an object might be represented as MySQL value, eg a 
 *  (primary) key.
 * 
 * 
 * @uses        Atom_Exception
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Db_ISQLValue {
    public function toSql();
}