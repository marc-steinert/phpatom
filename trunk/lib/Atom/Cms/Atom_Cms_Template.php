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
class Atom_Cms_Template {
   
    /** @var array */ 
	private $_bound = array();

    /**
     * Path to the template
     * 
     * @var string
     */
	private $_file;


    public function __construct($tplName, $tplDir = '' ) {
        // Define template directory
        if ($tplDir == '' && defined('TEMPLATE_DIR')) {
            $tplDir = TEMPLATE_DIR;
		}

        // Add trailing slash
        $tplDir = __dir($tplDir);

        // Get templates contents
        $this->_file = $tplDir.$tplName;
    }

    public function set($name, $value = null) {
        // Bind associative array
        if(is_array($name)) {
			foreach ($name as $key => $value) {
				$this->_bound[$key] = $value;
            }
        } else {
			// If instance of self then save as reference
            if ($value instanceof self) {
				$this->_bound[$name] = &$value;
			} else {
				$this->_bound[$name] = $value;
			}
        }
    }

	/**
	 * @throws	Atom_SystemException
     *
     * @return  string
	 */
    public function parse() {
        // Parse templates and bind to variables
        foreach ($this->_bound as $key => $value) {
            if ($value instanceof self) {
				$value = $value->parse();
            }

            $$key = $value;
        }

        // Start outputbuffering
        ob_start();

        // Include template
        if (!file_exists($this->_file)) {
			throw new Atom_Cms_FileNotFoundException('Template "'.$this->_file.'" not found.');
        }

		require($this->_file);

        // Stop buffering and get its contents
        return ob_get_clean();
    }

    public function setView(Atom_View $pView) {
        foreach ($pView->getVariables() as $name => $value) {
            $this->set($name, $value);
        }
    }
}
