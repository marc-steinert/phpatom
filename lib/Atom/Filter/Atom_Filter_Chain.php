<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Pipes input through multiple Atom_Filter_Interface instances.
 *
 * @example
 *  $someInput = 'abcde1234!§$%';
 *  $pFilterChain = new Atom_Filter_Chain($someInput);
 *  $pFilterChain->addFilter(new Atom_Filter_Alpha());
 *  var_dump($pFilterChain->getFilteredValue);
 * 
 * @uses        Atom_Filter_Interface
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Filter_Chain {
    
    /**
     * Array containing all filters to be applied to the value.
     * 
     * @var array
     */
    private $_filters = array();
    
    /** @var mixed */
    private $_value;
    
    
    /**
     * 
     * 
     * @param   mixed   $value Value which is about to be filtered.
     * @return  Atom_Filter_Chain
     */
    public function __construct($value) {
        $this->_value = $value;
    }
    
    public function addFilter(Atom_Filter_Interface $pFilter) {
        $this->_filters[] = $pFilter;
    }
    
    /**
     * Applies all previously added filters to the value and returns
     *  the filter output.
     * 
     * @throws  Atom_ArgumentException  If input value cannot be filtered.
     */
    public function getFilteredValue() {
        $filtered = $this->_value;
        
        foreach ($this->_filters as $curFilter) {
            $filtered = $curFilter->filter($filtered);
        }
        
        return $filtered;
    }
}
