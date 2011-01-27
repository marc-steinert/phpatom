<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * CMS parser.
 * 
 * @note
 *  Does all the request routing.
 *  Merges views and controllers.
 *  Called by <code>Atom_Main</code>.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Cms_Parser {

    /** @var Atom_View */
    private $_view;

    /** @var Atom_ControllerAbstract */
    private $_controller;

    private $_scripts = array();
    
    private $_stylesheets = array();
    
    
    public function __construct() { }

// {{{ Setters
    public function setView(Atom_View $pView) {
        $this->_view = $pView;
    }

    public function setController(Atom_ControllerAbstract $pController) {
        $this->_controller = $pController;
        $this->_view = $pController->getView();
    }

    public function setVariables(array $variables) {
        $this->_variables = $variables;
    }
// }}}

    public function render() {
        if ($this->_controller !== null) {
            // Run controller to manipulate view there first before
            //  extracting.
            $this->_controller->run();
        }

        switch (Atom_Main::instance()->getContext()) {
            case Atom_Main::CONTEXT_HTML:
                $pConfig = Atom_Config::instance();

                // Template
                $pMainTemplate = new Atom_Cms_Template(
                    $this->_view->getTemplate(), $pConfig->Paths->ApplicationDir.'templates/'
                );
                $pMainTemplate->setView($this->_view);

                // Content
                $pContentTemplate = new Atom_Cms_Template(
                    strtolower(Atom_Main::instance()->getControllerName().'.php'),
                    $pConfig->Paths->ApplicationDir.'views/'
                );
                
                $pMainTemplate->set('Scripts', $this->getScriptsBlock());
                $pMainTemplate->set('Stylesheets', $this->getStylesheetsBlock());
                
                $pContentTemplate->setView($this->_view);

                $pMainTemplate->set('content', $pContentTemplate);

                echo $pMainTemplate->parse();
                break;

            case Atom_Main::CONTEXT_JSON:
                // @todo replace with __setHeader
                header('Cache-Control: no-cache, must-revalidate');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                //header('Content-type: application/json');
                echo json_encode($this->_view->getVariables());
                exit; // Ensure there is no output appended
        }
    }
    
    public function addScript($uri) {
        $this->_scripts[] = $uri;
    }
    
    private function getScriptsBlock() {
        return Atom_Utils_Array::extendedImplode(
            '<script type="text/javascript" src="', '"></script>',
            "\n",
            $this->_scripts
        );
    }
    
    public function addStylesheet($uri) {
        $this->_stylesheets[] = $uri;
    }
    
    private function getStylesheetsBlock() {
        return Atom_Utils_Array::extendedImplode(
            '<link rel="stylesheet" href="', '" type="text/css" media="screen" charset="utf-8" />',
            "\n",
            $this->_stylesheets
        );
    }
}
