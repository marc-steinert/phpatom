<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_Db_Factory {

    /** @var Atom_Db_IAdapter */
    private static $_standardAdapter = null;

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
