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
class Atom_Log_FileWriter extends Atom_Log_StreamWriter {
    
    /**
     * 
     * @throws  Atom_FileNotFoundException
     * @throws  Atom_Log_Exception
     * 
     * @param   string  $logfilePath    Path to the logfile, we wan't to write to.
     * @return  Atom_Log_FileWriter
     */
    public function __construct($logfilePath) {
        if (!file_exists($logfilePath) || !is_writable($logfilePath)) {
            throw new Atom_FileNotFoundException(
                __('Logfile does not exists or is not writeable')
            );
        }
        
        parent::__construct(fopen($logfilePath, 'a'));
    }
}
