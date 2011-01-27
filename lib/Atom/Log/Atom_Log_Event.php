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
final class Atom_Log_Event {
    
    /** @var Atom_Date */
    private $_date;
    
    /** @var string */
    private $_message;
    
    /** @var int */
    private $_severityCode;
    
    /** @var string */
    private $_severityName;
    
    
    /**
     * 
     * 
     * @param   Atom_Date   $date
     * @param   string  $message
     * @param   int     $severityCode
     * @param   string  $severityName
     * @return  Atom_Log_Event
     */
    public function __construct(Atom_Date $date, $message, $severityCode, $severityName) {
        $this->_date = $date;
        $this->_message = $message;
        $this->_severityCode = $severityCode;
        $this->_severityName = $severityName;    
    }
    
    /**
     * 
     * @return  Atom_Date
     */
    public function getDate() {
        return $this->_date;
    }
    
    /**
     * 
     * @return  string
     */
    public function getMessage() {
        return $this->_message;
    }
    
    public function getSeverityCode() {
        return $this->_severityCode;
    }
    
    /**
     * 
     * @return  string
     */
    public function getSeverityName() {
        return $this->_severityName;
    }
}
