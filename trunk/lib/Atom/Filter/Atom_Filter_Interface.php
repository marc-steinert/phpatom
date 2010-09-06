<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Provides an interface for setting which value should get filtered for
 *  all filters shipped with the Atom framework.
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
interface Atom_Filter_Interface {
    
    /**
     * @throws  Atom_ArgumentException
     *   
     * @param   mixed   $value
     */
    public function filter($value);
}
