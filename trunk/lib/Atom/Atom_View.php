<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_View {

    /** @var array */
    private $_variables = array();

    /** @var array */
    private $_scripts = array();

    /** @var array */
    private $_stylesheets = array();

    /**
     * Template of the view
     *
     * @note    Is ignored in JSON context.
     *
     * @var     string
     */
    private $_templateName = 'main.php';

    /** @var string */
    private $_viewContent;


    public function __construct() {

    }
    
    /**
     * Sets a variable that is available in the view
     * 
     * @throws  Atom_SystemException
     * 
     * @param   string   $name
     * @param   mixed   $value
     */
    public function __set($name, $value) {
        if (!is_string($name)) {
            throw new Atom_SystemException();
        }
        
        // Prevent overwriting of private class vars
        if (substr($name, 0, 1) != '_') {
            $this->_variables[$name] = $value;
        }
    }

    public function __get($name) {
        return (
            $this->__isset($name) ? $this->_variables[$name] : null
        );
    }

    public function __isset($name) {
        return isset($this->_variables[$name]);
    }

    public function __unset($name) {
        unset($this->_variables[$name]);
    }

    /**
     * @return array
     */
    public function getVariables() {
        return $this->_variables;
    }

    public function getTemplate() {
        return $this->_templateName;
    }

    public function setTemplate($name) {
        $this->_templateName = $name;
    }

    public function enqueueScript($scriptname) {
        if (!in_array($scriptname, $this->_scripts)) {
            $this->_scripts[] = $scriptname;
        }
    }

    public function enqueueStylesheet($stylename) {
        if (!in_array($stylename, $this->_stylesheets)) {
            $this->_stylesheets[] = $stylename;
        }
    }
}
