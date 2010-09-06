<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Creates an registers standard database adapter.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert
 */
final class Atom_Db_Factory {
    
    /** @var Atom_Db_MySQLAdapter */
    private static $_standardAdapter = null;

    
    /**
     * Enforce static behaviour.
     * 
     */
    private function __construct() { }
    
    /**
     * Returns standard database adapter
     *
     * @return  Atom_Db_IAdapter
     */
    public static function get() {
        if (self::$_standardAdapter === null) {
            // Create a new standard adapter, if not present
            $pConfig = Atom_Config::instance();

            $pAdapter = new Atom_Db_MySQLAdapter($pConfig->Database->Database);
            $pAdapter->addMaster(
                $pConfig->Database->User,
                $pConfig->Database->Password,
                $pConfig->Database->Host
            );

            self::$_standardAdapter = $pAdapter;
        }

        return self::$_standardAdapter;
    }

    /**
     * Sets standard database adapter
     *
     * @param   Atom_Db_IAdapter $pAdapter
     */
    public static function register(Atom_Db_IAdapter $pAdapter) {
        self::$_standardAdapter = $pAdapter;
    }
}
