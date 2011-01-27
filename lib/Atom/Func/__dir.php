<?php
/**
 * Sanatizes directory names by appending trailing slash, if necessary.
 *
 * @param	$name	string
 * @return	string
 */
function __dir($name) {
	if (substr($name, strlen($name) - 1, 1) != '/' && $name != '') {
		$name .= '/';
	}
	
	return $name;
}
