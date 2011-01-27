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
class Atom_Log_StreamWriter implements Atom_Log_IWriter {
    
    /** @var string */
    private $_lineEnding = "\n";
    
    /** @var array */
    private $_events = array();
    
    private $_stream = null;
    
    private $_minimumSeverityLevel = 0;
    
    
    /**
     * 
     * @throws  Atom_Log_Exception
     * 
     * @param   mixed   $stream
     * @return  Atom_Log_StreamWriter
     */
    public function __construct($stream) {
        if (!is_resource($stream) || get_resource_type($stream) != 'stream') {
            throw new Atom_Log_Exception(
                __('')
            );
        }
        
        $this->_stream = $stream;
    }
    
    /**
     * 
     * 
     * @param   string    $lineEnding
     */
    public function setLineEnding($lineEnding) {
        $this->_lineEnding = $lineEnding;
    }
    
    /**
     * @see     Atom_Log_IWriter
     */
    public function shutdown() {
        $newLines = array();
        
        foreach ($this->_events as $curEvent) {
            $newLines[] = sprintf(
                '%s - %s: %s',
                $curEvent->getDate()->format('d.m.Y H:i:s'),
                $curEvent->getSeverityName(),
                $curEvent->getMessage()
            );
        }
        
        $toAppend = implode($this->_lineEnding, $newLines).$this->_lineEnding;
        
        fclose($this->_stream);
    }
    
    /**
     * @see     Atom_Log_IWriter
     */
    public function write(Atom_Log_Event $event) {
        $this->_events[] = $event;   
    }
    
    /**
     * @see Atom_Log_IWriter
     */
     public function setMinimumSeverity($minimumSeverityLevel) {
         $this->_minimumSeverityLevel = $minimumSeverityLevel;
     }
}
