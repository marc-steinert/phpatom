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
final class Atom_Main {

    const CONTEXT_JSON = 0;

    const CONTEXT_HTML = 1;

    /** @var Atom_Main */
    private static $_instance = null;

    /** @var Atom_ControllerAbstract */
    private $_controller;

    /** @var string */
    private $_controllerName;

    private $_actionName;

    /** @var Atom_ControllerAbstract */
    private $_pController;

    /** @var array */
    private $_routes = null;
    
    /** @var Atom_Cms_Parser */
    private $_parser = null;

    
    private function __construct() { }

// {{{ Properties
    /**
     * Singleton accessor
     *
     * @return Atom_Main
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
// }}}
    
    /**
     * 
     * @return  Atom_Cms_Parser
     */
    public function getParser() {
        return $this->_parser;
    }
    
    public function dispatch($routes = null) {
        $pConfig = Atom_Config::instance();

        $applicationDir = realpath(getcwd().'/..').'/';
        $pConfig->Paths->ApplicationDir = $applicationDir;

        // Set the root directory (the dir above /lib)
        $rootDir = realpath(dirname(__FILE__).'../../../').'/';
        $pConfig->Paths->RootDir = $rootDir;

        $this->_routes = $routes;
        $this->_controllerName = $this->getControllerName();
        $this->_actionName = $this->getActionName();
        
        // Get view, if in HTML context
        $pView = new Atom_View();
        $pView->Key = mb_strtolower($this->_controllerName);
        
        $this->_parser = new Atom_Cms_Parser($pView);
        
        // Instance controller
        $controllerPath =
            $applicationDir.'/controllers/'.$this->_controllerName.'Controller.php';

        if (file_exists($controllerPath)) {
            require_once($controllerPath);

            $controllerClassName = $this->_controllerName.'Controller';
            $this->_controller = new $controllerClassName($this->_controllerName, $this->_actionName);
            $this->_controller->setView($pView);
        }

        $this->_parser->setView($pView);

        // Now, its getting serious
        if ($this->_controller !== null) {
            $this->_parser->setController($this->_controller);
        }

        $this->_parser->render();
    }

    /**
     * @return bool
     */
    public static function getContext() {
        return (
            preg_match('/json/', Atom_HttpRequest::instance()->getQuery()) ?
                self::CONTEXT_JSON :
                self::CONTEXT_HTML
        );
    }

    /**
     *
     * @return string
     */
    public function getControllerName() {
        $controllerName = '';
        $uriPath = Atom_HttpRequest::instance()->getPath();


        if ($this->_routes !== null) {
            // There are routes, test if we have to overwrite the standard
            //  controller name.
            if (!is_array($this->_routes)) {
                throw new Exception();
            }

            foreach ($this->_routes as $pattern => $controllerName) {
                if (preg_match($pattern, $uriPath)) {
                    return ucfirst($controllerName);
                }
            }
        }

        // Set standard controller
        $pathParts = preg_split(
            '#/#', $uriPath, -1, PREG_SPLIT_NO_EMPTY
        );

        return ucfirst(
            isset($pathParts[0]) ? mb_strtolower($pathParts[0]) : 'index'
        );
    }

    /**
     * @return string
     */
    private function getActionName() {
        $path = preg_split(
            '#/#', Atom_HttpRequest::instance()->getPath(), -1, PREG_SPLIT_NO_EMPTY
        );

        return (count($path) > 1 ? array_pop($path) : 'index');
    }
}
