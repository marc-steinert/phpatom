<?php

/**
 * Loads a function by name.
 *
 * @param string $functionName
 */
function __func($functionName) {
    $filePath = 'lib/Atom/Func/'.$functionName.'.php';
    require_once($filePath);
}

/**
 * @return  Atom_Db_MysqlAdapter
 */
function __db() {
    return Atom_Db_Factory::get();
}

if (!defined('LIVE')) {
    /**
     * @deprecated
     */
    define('LIVE', false);
}

define('LF', chr(10));
define('ROOT_DIR', realpath(dirname(__FILE__).'/..').'/');

// Register autoloading
require 'lib/Atom/Atom_Loader.php';
spl_autoload_register(array('Atom_Loader', 'load'));

// {{{ Load standard framework functions
$coreFunctions = array(
	'__post', '__get', '__jsonContext', '__getArrayValue',
	'__dir', '__html', '__escape', '__setHeader',
	'__redirect', '__', '__e', '__user',
	'__isAuthenticated', '__tokenReplace', '__arrayVal', '__clean',
	'__addScript', '__addStylesheet'
);

array_walk($coreFunctions, create_function('$f', '__func($f);'));
// }}}

// Register Session handler
Atom_Session_Handler::instance();
