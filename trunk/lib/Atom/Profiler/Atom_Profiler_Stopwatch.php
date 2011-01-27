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
class Atom_Profiler_Stopwatch {
    
    /** @var Atom_Profiler_Stopwatch */
    private static $_instance = null;
    
    /** @var float */
    private $_start = 0;
    
    /** @var float */
    private $_stop = 0;
    
    /** @var array */
    private $_marks = array();
    
    
    private function __construct() { }
    
    /**
     * Singleton accessor
     * 
     * @return Atom_Profiler_Stopwatch
     */
    public function instance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    /**
     * Starts time measurement. 
     * 
     */
    public function start() {
        $this->_start = microtime(true);
    }
    
    /**
     * Adds a measuring point.
     * 
     * @param   string  $title
     */
    public function addMark($title = '') {
        $this->_marks[] = array(
            'Title' => (
                empty($title) ? __('No title') : $title
            ),
            'Time' => microtime(true)
        );
    }
    
    /**
     * Stops running time measurement.
     * 
     * @throws  Atom_Profiler_Exception
     */
    public function stop() {
        if ($this->_start == 0) {
            throw new Atom_Profiler_Exception(
                __('You have to start() the stopwatch, before calling stop().')
            );
        }
        
        $this->_stop = microtime(true);
    }
    
    /**
     * Returns the mesured time between all 
     * 
     * @throws  Atom_Profiler_Exception
     * 
     * @param   string  $lineEnding
     * @return  string
     */
    public function dump($lineEnding = "\n") {
        if (!is_string($lineEnding)) {
            throw new Atom_Profiler_Exception(
                __('No valid line ending given.')
            );
        }
        
        if ($this->_stop === 0) {
            $this->stop();
        }
        
        $totalTime = $this->_stop - $this->_start;
        
        $lines = array();
        $i = 0;
        
        foreach ($this->_marks as $curMark) {
            $timeSoFar = $curMark['Time'] - $this->_start;
            $percentage = round(($timeSoFar / $totalTime) * 100, 1);
            
            $lines[] = sprintf(
                '%i: %s %f\%', $i, $curMark['Title'], $percentage
            );
            
            ++$i;
        }
        
        $lines[] = 'Total: '.round($totalTime, 2).' Sec.';
        
        return implode($lineEnding, $lines);
    }
}
