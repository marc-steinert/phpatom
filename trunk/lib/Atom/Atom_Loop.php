<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Alternates between two or more values.
 *
 * @example
 *      $test = new Atom_Loop('black', 'white');
 *      foreach (range(1, 10) as $i) {
 *          echo '<tr color="'.$text.'">'.$i.'</tr>';
 *      }
 *
 *      Alternates on each table row (<tr>) between black and white.
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Loop {

    /** @var int */
    private $_index = 0;

    /** @var array */
    private $_elements;

    /** @var int */
    private $_elementsCount;


    public function __construct() {
        $this->_elements = func_get_args();
        $this->_elementsCount = func_num_args();
    }

    /**
     * Adds an element to cycle through
     *
     * @param   mixed   $element
     */
    public function set($element) {
        $this->_elements[] = $element;
        $this->_elementsCount++;
    }

    public function __toString() {
        if ($this->_elementsCount == 0) {
            return null;
        }

        $val = $this->_elements[($this->_index % $this->_elementsCount)];
        $this->_index++;

        return $val;
    }
}
