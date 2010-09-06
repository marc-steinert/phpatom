<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Registry for config variables used within Atom.
 *
 * @example
 *  $pConfig = Atom_Config::instance();
 *  // Set config variable 'Username' in Section 'Database'
 *  $pConfig->Database->Username = 'root'; 
 *  $pConfig->Database->Password = '1234';
 * 
 *  // Prints config value
 *  echo $pConfig->Database->Username;
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Config {

    /** @var array */
    public static $_config = array();

    /** @var Atom_Config */
    private static $_instance = null;

    /** @var string */
    private $_loadedSection;


    /**
     *
     *
     * @param   string      $loadedSection  Determines which section to use
     * @return  Atom_Config
     */
    private function __construct($loadedSection = '') {
        $this->_loadedSection = $loadedSection;
    }

    /**
     * Singleton accessor
     *
     * @return  Atom_Config
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * @return  string|Atom_Config
     */
    public function __get($key) {
        $result = null;
        $data = self::$_config;

        if ($this->_loadedSection != '') {
            $data = self::$_config[$this->_loadedSection];
        }

        if (!isset($data[$key])) {
            $data[$key] = array();
        }

        if (is_array($data[$key])) {
            // Trying to access a section
            $result = new self($key);
        } else {
            // Found a value
            $result = $data[$key];
        }

        return $result;
    }

    public function __set($key, $value) {
        if ($this->_loadedSection == '') {
            self::$_config[$key] = $value;
        } else {
           self::$_config[$this->_loadedSection][$key] = $value;
        }
    }

    /**
     * @return  bool
     */
    public function __isset($key) {
        return (
            $this->_loadedSection != '' ?
                self::$_config[$this->_loadedSection] :
                self::$_config[$key]
        );
    }
    
    /**
     * 
     * @throws  Atom_FileNotFoundException
     * 
     * @param   string  $filename   Fully qualified path to the ini file to parse
     */
    public function importFromIniFile($filename) {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Atom_FileNotFoundException(
                'ini file "'.$filename.'" does not exits'
            );
        }

        self::$_config = parse_ini_file($filename, true);
    }
}
