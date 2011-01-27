<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Simple ICal parser
 * 
 * @uses        Atom_Exception
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_ICal_Generator {
    
    const LF = "\r\n";
    
    const VERSION = '2.0';
    
    /** @var string */
    private $_prodid = 'Atom iCal generator';
    
    /** @var array */
    private $_events = array();
    
    
    public function __construct() { }
    
    public function setProdid($prodId) {
        $this->_prodid = $prodId;
    }
    
    /**
     * @return   string
     */
    public function getProdid() {
        return $this->_prodid;
    }
    
    /**
     * 
     * 
     * @param   mixed       $name
     * @param   mixed       $summary
     * @param   mixed       $description
     * @param   Atom_Date   $start
     * @param   Atom_Date   $end
     * @param   mixed       $public
     * @return  string
     */
    public function addEvent($name, $summary, $description, Atom_Date $start, Atom_Date $end, $public = true) {
        $event = array(
            'BEGIN:VEVENT',
            'UID:',
            'ORGANIZER;CN=\MAILTO:',
            'SUMMARY:',
            'DESCRIPTION:',
            'CLASS:PUBLIC',
            'DSTART:'.$start->toZulu(),
            'DTEND:'.$end->toZulu(),
            'DTSTAMP:'.Atom_Date::getNow()->toZulu(),
            'END:VEVENT'
        );
        
        array_walk(
            $event, array('Atom_ICal_Generator', 'escape')
        );
        
        return implode(self::LF, $event);
    }
    
    public function getContent() {
        $head = array(
            'BEGIN:VCALENDAR',
            'VERSION:'.self::VERSION,
            'PRODID:'.$this->_prodid,
            'METHOD:PUBLISH',
            'END:VCALENDAR'
        );
        
        
        return implode(
            self::LF,
            array_merge($head, $this->_events)
        );
    }
    
    private static function escape($input) {
        return addcslashes($input, '\\');
    }
}