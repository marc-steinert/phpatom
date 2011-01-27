<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Generates an URL to a pie chart via the Google charts API.
 * 
 * @example
 *  http://chart.apis.google.com/chart?chs=300x225&cht=p&chd=t:5.5,2,3,4&chdl=legend1|legend2|legend3|legend4&chl=1|2|3|4&chp=0&chco=000000,000000,000000&chtt=fsgsfd
 * 
 * @uses        Atom_Charts_GoogleChartAbstract
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Charts_GooglePieChart extends  Atom_Charts_GoogleChartAbstract {
    
    /** @var array */
    private $_labels = array();

    /** @var array */
    private $_colors = array();

    /**
     * 
     * 
     * @param   string   $label
     * @param   string|int|float   $value
     * @param   string   $color
     */
    public function addData($label, $value, $color = '') {
        $this->_labels[] = urlencode($label);
        $this->_values[] = self::format($value);
        
        if (!empty($color) && preg_match('/^#?[0-9a-f]{6}$/', $color)) {
            $this->_colors[] = preg_replace('/^#/', '', $color);
        }
    }
    
    protected function getOptions() {
        return array(
            'cht=p',
            'chs='.$this->_width.'x'.$this->_height,
            'chd=t:'.implode(',', $this->_values),
            'chl='.implode('|', $this->_labels),
            'chp=0',
            //'chco='.implode(',', $this->_colors)
        );
    }
}
