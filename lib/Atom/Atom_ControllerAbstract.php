<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * 
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
abstract class Atom_ControllerAbstract {

    /** @var Atom_View */
    protected $_view = null;

    private $_name;

    protected $_action;


    /**
     *
     *
     * @param string $name Name of the controller
     * @param string $action Name of the action, we want to run
     * @return Atom_ControllerAbstract
     */
    final public function __construct($name, $action) {
        $this->_name = $name;
        $this->_action = $action;
        
        if (method_exists($this, '__init')) {
            $this->__init();
        }
    }

    final public function setView(Atom_View $pView) {
        $this->_view = $pView;
    }

    /**
     * @return Atom_View
     */
    final public function getView() {
        return $this->_view;
    }

    public function run() {
        $actionMethodName = strtolower($this->_action).'Action';

        if (method_exists($this, $actionMethodName)) {
            $this->{$actionMethodName}();
        } else if (method_exists($this, 'defaultAction')) {
            $this->defaultAction();
        }
    }
}
