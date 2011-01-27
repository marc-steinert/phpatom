<?php

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

		return self::createTag(
			'select',
			$attr,
			implode(LF, $options)
		);
    }

	/**
	 * Builds a single HTML tag
	 *
	 * @param	string	$name   Tag name
	 * @param	array	$attr   Tag attributes
	 * @param	string	$innerHtml  Contents between the tags
     * @return  string
	 */
	public static function createTag($name, array $attr, $innerHtml) {
        $attrOut = '';
        
        if (count($attr)) {
            array_walk($attr, create_function('&$i,$k','$i=" $k=\"$i\"";'));
            $attrOut = implode(LF, $attr);
        }
        
		return sprintf(
            '<%s%s>%s</%s>',
            $name, $attrOut, $innerHtml, $name
        );
	}
}
