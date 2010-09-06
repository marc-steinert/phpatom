<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Collection of generic helper methods for generating HTML code.
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Utils_Html {

	/**
	 * Enforce static behaviour
	 *
	 */
    private function __construct() { }


	/**
	 * Creates a HTML select, using an associative array as input.
	 *
	 * @param	array	$input			options as key => value pair
	 * @param	array	$attr			Attributes of the tag, as key => value pair
	 * @param	mixed	$selected		Which element of the select, is preselected?
	 * @return	string	HTML code
	 */
    public static function select(array $input, array $attr, $selected = null) {
		$options = array();

        foreach ($input as $key => $value) {
			$options[] = '<option value="'.__html($value).'"'.($selected == $value ? ' selected="selected"' : '').'>'.__html($key).'</option>';
		}

		return  self::createTag(
			'select',
			$attr,
			implode(LF, $options)
		);
    }

	/**
	 * Builds a single HTML tag
	 *
	 * @param	string	$name   Tagname
	 * @param	array	$attr   Assoc. Array with name->value pairs for attribute names/values
	 * @param	string	$innerHtml  Text between opening and closing Tag
	 */
	private static function createTag($name, array $attr, $innerHtml) {
		return
			'<'.$name.(
					count($attr) ?
						' '.array_walk($attr, create_function('&$i,$k','$i=" $k=\"$i\"";')) : '').
			'>'.$innerHtml.'</'.$name.'>';
	}
}
