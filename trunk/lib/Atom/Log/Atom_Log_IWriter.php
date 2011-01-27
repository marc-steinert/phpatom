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
interface Atom_Log_IWriter {
    
    /**
     * 
     * 
     */
    public function shutdown();
    
    /**
     * 
     * 
     * @param   Atom_Log_Event  $event
     */
    public function write(Atom_Log_Event $event);
    
    /**
     * 
     * 
     * @param   int   $minimumSeverity
     */
    public function setMinimumSeverity($minimumSeverityLevel);
}
