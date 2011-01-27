<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Wrapper for MySQL query results.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_Db_Result implements Iterator, Countable, ArrayAccess {

    /** @var recource */
    private $_result;

    /** @var int */
    private $_numRows;

    /** @var int */
    private $_index = 0;

    /** @var array */
    private $_data = array();


    /**
     * Constructor
     *
     * @throws  Atom_Db_Exception
     *
     * @param resource $result
     */
    public function __construct($result) {
        if (!is_resource($result)) {
            throw new Atom_Db_Exception('No valid SQL result given.');
        }

        $this->_result = $result;
        $this->_numRows = mysql_num_rows($this->_result);

        while(($row = mysql_fetch_assoc($this->_result))) {
            $this->_data[] = $row;
        }
    }

    public function __get($key) {
        return $this->_data[$this->_index][$key];
    }

    public function __isset($key) {
        return array_key_exists($this->_data[$this->_index], $key);
    }

    /**
     * Fetches all rows targeted by the db result as array
     *
     * @return array
     */
    public function fetchAll() {
        return $this->_data;
    }

    /**#@+
     * Implemention of Iterator-interface
     */
    public function rewind() {
        $this->_index = 0;
    }

    public function valid() {
        return ($this->_index + 1 <= $this->_numRows);
    }

    public function current() {
        return $this->_data[$this->_index];
    }

    public function key() {
        return $this->_index;
    }

    public function next() {
        $this->_index++;
    }
    /**#@-*/

    /**#@+
     * Implemention of Countable-Interface
     */
    /**
     * Gets number of rows of the current SQL result
     *
     * @return int
     */
    public function count() {
        return $this->_numRows;
    }
    /**#@-*/

    /**#@+
     * Implemention of ArrayAccess-Interface
     */
    public function offsetExists($offset) {
        return isset($this->_data[$this->_index][$offset]);
    }

    public function offsetSet($offset, $value) {
        $this->_data[$this->_index][$offset] = $value;
    }

    public function offsetGet($offset) {
        return $this->_data[$this->_index][$offset];
    }

    public function offsetUnset($offset) { }
    /**#@-*/
}