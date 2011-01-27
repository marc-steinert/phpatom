<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Describes methods a model object must implement.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Db_IModel {
    static function getTableName();
    static function getPrimaryName();
}
