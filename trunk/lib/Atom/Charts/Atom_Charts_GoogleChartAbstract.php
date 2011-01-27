<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Base class for Google charts API access.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
abstract class Atom_Charts_GoogleChartAbstract {
    
    /** @var string */
    const API_BASE_URI = 'http://chart.apis.google.com/chart?';
    
    /** @var string */
    protected $_title;
    
    /** @var int */
    protected $_width;
    
    /** @var int */
    protected $_height;
    
    /** @var array */
    protected $_values = array();
    
    
    /**
     * @param mixed $title
     * @param mixed $width
     * @param mixed $height
     * @return Atom_Charts_GoogleChartAbstract
     */
    public function __construct($title, $width, $height) {
        $this->_title = abs((int) $title);
        $this->_width = abs((int) $width);
        $this->_height = $height;
    }
    
    public function __toString() {
        return $this->getUrl();
    }
    
    /**
     * @param   mixed   $number
     * @return  string
     */
    protected static function format($number) {
        return number_format(
            floatval($number), 2, '.', ''
        );
    }
    
    /**
     * 
     * 
     * @return  string
     */
    public function getUrl() {
        return self::API_BASE_URI.implode('&', $this->getOptions());
    }
    
    abstract protected function getOptions();
}
