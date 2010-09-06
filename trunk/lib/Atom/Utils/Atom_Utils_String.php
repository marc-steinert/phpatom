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
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Utils_String {
    
    /**
     * Enforce static behaviour.
     * 
     */
    private function __construct() { }
    
    /**
     * Converts links in the input string to HTML links.
     * 
     * @param	string    $input
     * @param	string    $className    Css class name of the newly created a-tag
     * @param	string    $style        Contents of the style-attribute
     * @return	string
     */
    public static function linksToATags($input, $className = '', $style = '') {
		$pattern =
        "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";
			
		preg_match_all($pattern, $text, $matches);
		
		foreach ($matches[0] as $url) {
			$linkHtml = 
			'<a href="'.__html($url).'" target="_blank"'.
				(empty($style) ? '' : ' style="'.$style.'"').
				(empty($className) ? '' : ' class="'.__html($className).
			'>'.
				__html($url).
			'</a>';
		
			$text = str_replace($url, $linkHtml, $text);
		}
		
		return $text;
    }
    
    public static function shortenText($text, $len, $ending = '...') {
		$len = (int) $len;
		
        if (mb_strlen($text) < $len) {
            return $text;
        }
        
        return mb_substr($text, 0, $len - 3).'...';
    }
}
