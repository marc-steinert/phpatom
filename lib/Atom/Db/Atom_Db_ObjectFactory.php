<?php
<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * @deprecated
 */
final class Atom_Db_ObjectFactory  {

    private static $_objectCache = array();


    public static function set($className, $primaryValue, $instance) {
        if (!isset(self::$_objectCache[$className])) {
            self::$_objectCache[$className] = array();
        }

        self::$_objectCache[$className][$primaryValue] = $instance;
    }

    public static function get($className, $primaryValue) {
        $value = null;

        if (isset(self::$_objectCache[$className][$primaryValue])) {
            $value = self::$_objectCache[$className][$primaryValue];
        } else {
            $value = new $className($primaryValue);
            self::$_objectCache[$className][$primaryValue] = $value;
        }

        return $value;
    }
}