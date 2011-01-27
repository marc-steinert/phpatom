<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Defines generic database access methods
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Db_IAdapter {
    public function read($query);
    public function write($query);
}
