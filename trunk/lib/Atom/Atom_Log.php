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
class Atom_Log {
    
    /** Imidiate action is required */
    const SEVERITY_EMERGENCY = 0;
    
    /**  */
    const SEVERITY_ALERT = 1;

    /** */
    const SEVERITY_CRITICAL = 2;
    
    /** */
    const SEVERITY_ERROR = 4;
    
    /** */
    const SEVERITY_WARNING = 8;
    
    /** */
    const SEVERITY_NOTICE = 16;
    
    /** */
    const SEVERITY_INFO = 32;
    
    /** */
    const SEVERITY_DEBUG = 64;
    
    
    /** @var array */
    private $_writers = array();
    
    
    /**
     * 
     * 
     * @var array
     */
    private $_severityNames;
    
    
    /**
     * 
     * 
     * @param Atom_Log_WriterAbstract $writer
     * @return Atom_Log
     */
    public function __construct(Atom_Log_WriterAbstract $writer) {
        $pReflection = new ReflectionClass($this);
        $this->_severityNames = array_flip($pReflection->getConstants());
        $this->addWriter($writer);
    }
    
    public function __destruct() {
        foreach ($this->_writers as $curWriter) {
            $curWriter->shutdown();
        }
    }
    
    /**
     *  
     * 
     * @param Atom_Log_WriterAbstract $writer
     */
    public function addWriter(Atom_Log_WriterAbstract $writer) {
        $this->_writers[] = $writer;
    }
    
    /**
     *  
     * 
     * @param Atom_Log_WriterAbstract $writer
     * @return bool
     */
    public function hasWriter(Atom_Log_WriterAbstract $writer) {
        return in_array($writer, $this->_writers);
    }
    
    /**
     * 
     * @throws  Atom_Log_Exception
     * 
     * @param   string  $message
     * @param   int     $severity
     */
    public function log($message, $severity) {
        switch ($severity) {
            case self::SEVERITY_ALERT:
            case self::SEVERITY_CRITICAL:
            case self::SEVERITY_DEBUG:
            case self::SEVERITY_EMERGENCY:
            case self::SEVERITY_ERROR:
            case self::SEVERITY_INFO:
            case self::SEVERITY_NOTICE:
            case self::SEVERITY_WARNING:
                break;
            default:
                throw new Atom_Log_Exception(__('Undefinded severity level'));
        }
        
        $pEvent = new Atom_Log_Event(
            Atom_Date::getNow(),
            $message,
            $severity,
            $this->_severityNames[$severity]
        );
        
        foreach ($this->_writers as $curWriter) {
            $curWriter->write($pEvent);
        }
    }
}