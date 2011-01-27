<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Maps child classes to a MySQL 
 *
 * @uses        Atom_Db_IAdapter
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Db_MySQLAdapter implements Atom_Db_IAdapter {

    /** @var array */
    private static $_queries = array();

    /** @var resource */
    private $_linkMaster = null;

    /** @var resource */
    private $_linkSlave = null;

    /** @var string */
    private $_database;


    public function __construct($database) {
        $this->_database = $database;
    }

    public function addMaster($user, $password, $host) {
        $this->_linkMaster = $this->connect(
            $host,
            $user,
            $password,
            $this->_database
        );
    }

    public function addSlave(array $configArray) {
        throw new Atom_SystemException(
            __CLASS__.'::'.__METHOD__.' not implemented. Sorry :('
        );
    }

    /**
     * Connects to a MySQL server.
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return resource
     */
    private function connect($host, $user, $password, $database) {
        $link = mysql_connect($host, $user, $password, true);

        if ($link === false) {
            throw new Atom_Db_Exception(mysql_error(), mysql_errno());
        }

        if (!mysql_select_db($database, $link)) {
            throw new Atom_Db_Exception(mysql_error($link), mysql_errno($link));
        }

        mysql_query("SET NAMES 'utf-8'", $link);

        /*
            @todo Timezone
            mysql_query("SET time_zone = '".$config['defaultTimezone']."'", $link);
        */

        return $link;
    }

    /**
     * Executes the SQL query on the established database connection
     *
     * @param mixed $query
     * @return Atom_Db_Result
     */
    public function read($query) {
        self::$_queries[] = $query;

        $link = (
            $this->_linkSlave === null ? $this->_linkMaster : $this->_linkSlave
        );

        $result = mysql_query($query, $link);

        if ($result === false) {
            throw new Atom_Db_Exception(
                mysql_error($link),
                mysql_errno($link)
            );
        }

        return new Atom_Db_Result($result);
    }

    /**
     * Executes queries, that don't expect returned rows.
     *
     * @param string $query
     * @return int Affected rows
     */
    public function write($query) {
        self::$_queries[] = $query;

        $result = mysql_query($query, $this->_linkMaster);

         if ($result === false) {
            throw new Atom_Db_Exception(
                mysql_error($this->_linkMaster),
                mysql_errno($this->_linkMaster)
            );
        }

        return mysql_affected_rows($this->_linkMaster);
    }

    /**
     *
     *
     * @param   string  $table
     * @param   mixed   $conditions
     * @param   mixed   $order
     * @param   mixed   $limit
     */
    public function select($source, $conditions, $order = '', $limit = '') {
        $tablename = '';
        $useModel = false;

        if (class_exists($source) && is_subclass_of($source, 'Atom_Db_Model')) {
            $tablename = $source::getTableName();
            $useModel = true;
        } else {
            $tablename = $source;
        }
        
        if (is_array($conditions)) {
            $whereConditions = array();

            foreach ($conditions as $field => $value) {
                $whereConditions[] = "`".__escape($field)."`='".__escape($value)."'";
            }
            
            $whereConditions = implode(" AND ".LF, $whereConditions);
        } else {
            $whereConditions = $conditions;
        }
        
        $query =
            "SELECT * FROM `".__escape($tablename)."` WHERE ".
                $whereConditions.
                ($order != '' ? 'ORDER BY '.__escape($order) : '').LF.
                ($limit != '' ? 'LIMIT '.__escape($limit) : '');
        
        $rslt = $this->read($query);

        if ($useModel) {

            // Instanciate model objects
            $ret = array();
            $primaryName = $source::getPrimaryName();

            foreach ($rslt as $curRslt) {
                $ret[] = new $source($curRslt[$primaryName]);
            }

            return $ret;
        } else {
            return $rslt;
        }
    }

    public function delete($table, array $conditions, $order = '', $limit = '') {
        $tmp = array();

        foreach ($conditions as $field => $value) {
            $tmp[] = "`".__escape($field)."`='".__escape($value)."'";
        }

        $deleteQuery =
            "DELETE FROM `".__escape($table)."` WHERE ".
                implode(LF." AND ", $tmp)." ".
                ($order != '' ? 'ORDER BY '.__escape($order) : '').LF.
                ($limit != '' ? 'LIMIT '.__escape($limit) : '');

        return $this->write($deleteQuery);
    }

    public function insert($table, array $values) {

        $insertQuery = "INSERT INTO `".__escape($table)."` SET";

        $setValues = array();

        foreach ($values as $field => $value) {
            $setValues []= '`'.__escape($field)."`='".__escape(($value instanceof Atom_Db_ISQLValue ? $value->toSql() : $value))."'";
        }

        $insertQuery .= " ".join(",".LF." ", $setValues);

        $this->write($insertQuery);

        return $this->insertId();
    }

    /**
     *
     *
     * @param mixed $table
     * @param mixed $updates
     * @param mixed $conditions
     * @return int
     */
    public function update($table, array $updates, array $conditions) {
        // Konditionen zusammenfuegen
        $conditionsClean = array();

        foreach ($conditions as $field => $value) {
            $conditionsClean[] = "`".__escape($field)."`='".__escape($value)."'";
        }

        // Update-Set zusammenfuegen
        $updatesClean = array();

        foreach ($updates as $field => $value) {
            $updatesClean[] =
                "`".__escape($field)."`='".__escape($value)."'";
        }

        $updateQuery =
            "UPDATE `".
                __escape($table).
            "` SET ".
                implode(LF.", ", $updatesClean).LF.
            "WHERE ".
                implode(LF." AND ", $conditionsClean);

        return $this->write($updateQuery);
    }

    /**
     * @return int
     */
    public function affectedRows() {
        return mysql_affected_rows($this->_linkMaster);
    }

    /**
     * Gets primary key of last inserted row
     *
     * @return mixed
     */
    public function insertId() {
        return mysql_insert_id($this->_linkMaster);
    }

    /**
     * @return array
     */
    public function getQueries() {
        return self::$_queries;
    }
}
