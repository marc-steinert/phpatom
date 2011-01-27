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
class Atom_Log_NullWriter implements Atom_Log_IWriter {
    
    /**
     * @see     Atom_Log_IWriter
     */
    public function write(Atom_Log_Event $event) { }
    
    /**
     * @see     Atom_Log_IWriter
     */
    public function shutdown() { }
    
    /**
     * @see     Atom_Log_IWriter
     */
    public function setMinimumSeverity($minimumSeverity);
}
