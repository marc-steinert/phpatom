<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * An entry/article/story which will be displayed in a RSS feed.
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Rss_Item {
	
	private $_title;
	private $_description;
	private $_author;
	private $_link;
	
	/** @var Atom_Date */
	private $_date;
	
	
	public function __construct($title, $description, $link, Atom_Date $date) {
		$this->_title = $title;
		$this->_description = $description;
		$this->_date = $date;
		$this->_link = $link;
	}
	
	public function setAuthor($name, $email) {
		$this->_author = $name.', '.$email;
	}
	
	public function toXml() {
		$itemXml = 
			'<item>'.
				'<title>'.self::sanatize($this->_title).'</title>'.
				'<description>'.self::sanatize($this->_description).'</description>'.
				'<link>'.self::sanatize($this->_link).'</link>'.
				(
					!empty($this->_author) ?
						'<author>'.self::sanatize($this->_author).'</author>' : ''
				).
				'<guid>'.$this->getGuid().'</guid>'.
				'<pubDate>'.$this->_date->toRss().'</pubDate>'.
			'</item>';
			
		return $itemXml;
	}
	
	private function getGuid() {
		return $this->_link;
	}
	
	private static function sanatize($input, $useCdata = false) {
		$sane = '';
	
		if ($useCdata) {
			$sane = '<![CDATA['.$input.']]>';
		} else {
			$sane = htmlentities(strip_tags($input));
		}
		
		return $sane;
	}
}