<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Generates ICal files/data.
 * 
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
    
    /**
     * 
     * 
     * @param mixed $prodId
     */
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
    public function addEvent($uid, $summary, Atom_Date $start, Atom_Date $end) {
        $event = array(
            'BEGIN:VEVENT',
            'DTSTART:'.$start->toZulu(),
            'DTEND:'.$end->toZulu(),
            'DTSTAMP:'.$start->toZulu(),
            'UID:'.$uid,
            'SUMMARY:'.$summary,
            'CLASS:PUBLIC',
            'END:VEVENT'
        );
        
        array_walk(
            $event, array('Atom_ICal_Generator', 'normalize')
        );
        
        $this->_events[] = implode(self::LF, $event);
    }
    
    /**
     * 
     * @return  string
     */
    public function toICal() {
        $head = array(
            'BEGIN:VCALENDAR',
            'VERSION:'.self::VERSION,
            'PRODID:'.$this->_prodid,
            'METHOD:PUBLISH'
        );
        
        $foot = array(
            'END:VCALENDAR'
        );
        
        return implode(
            self::LF,
            array_merge($head, $this->_events, $foot)
        );
    }
    
    private static function normalize($line) {
        if (strlen($line) > 60) {
            // @todo iCal lines must be shorter than 60 chars
        }
        
        return self::escape($line);
    }
    
    private static function escape($input) {
        return addcslashes($input, '\\');
    }
}