<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Generates an URL to a line chart with x- & y-axis via the Google
 *  charts API.
 * 
 * @example
 *  http://chart.apis.google.com/chart?&chs=100x150&cht=lc&chco=76A4FB&chd=t:1,112,3,4,5,&chls=2&chma=40,20,20,30
 * 
 * @uses        Atom_Charts_GoogleChartAbstract
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Charts_GoogleLineChart extends Atom_Charts_GoogleChartAbstract {
    
    /** @var string */
    private $_color = '76A4FB';
    
    /** @var int */
    private $_marginLeft = 10;
    
    /** @var int */
    private $_marginTop = 10;
    
    /** @var int */
    private $_marginRight = 10;
    
    /** @var int */
    private $_marginBottom = 10;
    
    private $_labels = array();
    
    private $_max = 0;
    
    private $_yAxis = array();
    
    /**
     * 
     * 
     * @param   int     $left
     * @param   int     $top
     * @param   int     $right
     * @param   int     $bottom
     */
    public function setMargins($left, $top, $right, $bottom) {
        $this->_marginLeft = (int) $left;
        $this->_marginTop = (int) $top;
        $this->_marginRight = (int) $right;
        $this->_marginBottom = (int) $bottom;
    }
    
    /**
     * Sets the color of the graph.
     * 
     * @param   string   $color
     */
    public function setColor($color) {
        if (!preg_match('/^#?[0-9a-f]{6}/i', $color)) {
            throw new Atom_ArgumentException('');
        }
        
        $this->_color = strtoupper(
            str_replace('#', '', $color)
        );
    }
    
    /**
     * Add a value
     * 
     * @param   string|int|float    $value
     * @param   string              $label
     */
    public function addValue($value, $label) {
        if ($value > $this->_max) {
            $this->_max = $value;
        }
        
        $this->_values[] = self::format($value);
        $this->_labels[] = urlencode($label);
    }
    
    public function setYAxis(array $values) {
        $this->_yAxis = $values;
    }
    
    /**
     * Gets peak value of the graph.
     * 
     * @return  mixed
     */
    public function getMax() {
        return $this->_max;
    }
    
    protected function getOptions() {
        // Since google line charts accept values 0 < x < 100 only, we have
        //  to calculate percental values
        $valPercentage = array();
        
        if ($this->_max == 0) {
            // Avoid devision by zero
            $valPercentage[] = 0;
        } else {
            foreach ($this->_values as $curValue) {
                $valPercentage[] = round(($curValue / $this->_max) * 100, 2);
            }
        }
        
        if (isset($this->_yAxis[0])) {
            $chxl =
                '0:|'.implode('|', $this->_labels).'|1:|'.implode('|', $this->_yAxis);
        } else {
            $chxl = '0:|'.implode('|', $this->_labels);
        }
        
        return array(
            'chxt=x,y',
            'chs='.$this->_width.'x'.$this->_height,
            'cht=lc',
            'chco='.$this->_color,
            'chd=t:'.implode(',', __html($valPercentage)),
            'chxl='.$chxl,
            'chls=2', // Line thickness,
            'chma='.$this->_marginLeft.','.$this->_marginTop.','.$this->_marginRight.','.$this->_marginBottom
        );
    }
}