<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Base model class.
 *
 * @uses        Atom_Db_IModel
 * @uses        Atom_IEqual
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
abstract class Atom_Db_Model implements Atom_Db_IModel, Atom_IEqual {

    /**
     * Primary key value
     *
     * @var     mixed
     */
    private $_id;

    /**
     *
     *
     * @var     array
     */
    private $_tableData;


    /**
     *
     * @throws  Atom_ArgumentExcpetion
     *
     * @param   mixed $id
     * @return  Atom_Db_Model
     */
    public final function __construct($id) {
        $this->_id = $id;

        // @todo Object cache

        /**
         * @note self::getTableName() won't work, although
         *  defined static in Atom_Db_IModel
         */
        $rslt = __db()->select(
            $this->getTableName(),
            array(
                $this->getPrimaryName() => $this->_id
            ),
            '',
            '0,1'
        );

        if (count($rslt) !== 1) {
            throw new Atom_ArgumentException(
                ''
            );
        }

        $this->_tableData = $rslt->current();

        if (method_exists($this, '__init')) {
            $this->__init();
        }
    }

    /**
     *
     * @return  string
     */
    public final function getHashcode() {
        return $this->getTableName.'_'.self::getPrimaryName;
    }

    /**
     *
     * @return   array
     */
    public function getTableData() {
        return $this->_tableData;
    }

    /**
     * Allows reading access to row fields.
     *
     * @throws  Atom_SystemException
     *
     * @param   string   $key
     * @return  mixed
     */
    public function __get($key) {
        if (!isset($this->_tableData[$key])) {
            throw new Atom_SystemException(
                'Field "'.$key.'" does not exists in "'.get_class($this).'"'
            );
        }

		$value = $this->_tableData[$key];
		
		if (preg_match('/^\d{4}\-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $value)) {
			// Field is Datetime
			$value = new Atom_Date($value);
		}
		
        $hookMethodName = 'hookGet_'.$key;
        
        if (method_exists($this, $hookMethodName)) {
            $value = $this->{$hookMethodName}($value);
        }
        
        return $value;
    }

    /**
     * Allows write access to row fields
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        if ($key === $this->getPrimaryName()) {
            throw new Atom_SystemException(
                __('Cannot set primary identifier')
            );
        }

        $hookMethodName = 'hookSet_'.$key;

        if (method_exists($this, $hookMethodName)) {
            $value = $this->{$hookMethodName}($value);
        }

        if ($value instanceof Atom_Db_ISQLValue) {
            $value = $value->toSql();
        }
        
        if (isset($this->_tableData[$key])) {
            $this->_tableData[$key] = $value;
        }

        __db()->update(
            $this->getTableName(),
            array($key => $value),
            array($this->getPrimaryName() => $this->_id)
        );
    }

    /**
     * Deletes the table row.
     *
     */
    final public function delete() {
        if (method_exists($this, 'onDelete')) {
            $this->onDelete();
        }

        $class = get_called_class();

        __db()->delete(
            $this->getTableName(),
            array(
                $class::getPrimaryName() => $this->_id
            )
        );
    }

    protected static function create(array $values) {
        $class = get_called_class();
        $table = call_user_func(array($class, 'getTableName'));

        foreach ($values as $field => $value) {
            $hookFunc = sprintf('hookSet_%s', $field);
            
            if (method_exists($class, $hookFunc)) {
                $values[$field] = call_user_func(
                    array($class, $hookFunc),
                    ($value instanceof Atom_Db_ISQLValue ? $value->toSql() : $value)
                );
            }
        }

        $id = __db()->insert($table, $values);

        return new $class($id);
    }
    
    /**
     * Implementation of Atom_IEqual
     * 
     * @param   mixed   $other
     * @return  bool
     */
    public function equal(/*Atom_Db_IModel*/ $other) {
        $isEqual = false;
        
        if (get_class($this) == get_class($other)) {
            // Same type
            if ($this->_id == $other->{$other::getPrimaryName()}) {
                $isEqual = true;
            }
        }
        
        return $isEqual;
    }
    
    /**
     * Gets the primary key value
     * 
     * @return  mixed
     */
    public function getPrimaryValue() {
        return $this->_id;
    }
    
    /**
     * @return   array
     */
    public function toArray() {
        return $this->_tableData;
    }
}
