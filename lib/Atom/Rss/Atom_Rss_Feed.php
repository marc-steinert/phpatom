<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Represents a RSS 2.0 feed.
 * 
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Rss_Feed {

	const VERSION = '2.0';
	
	private $_title;
	
	private $_rssItems = array();
	
	
    /**
     * 
     * 
     * @param   string          $title
     * @return  Atom_Rss_Feed
     */
	public function __construct($title) {
		$this->_title = $title;
		
	}
	
    /**
     * Adds an RSS entry/story.
     * 
     * @param Atom_Rss_Item $pItem
     */
	public function addRssItem(Atom_Rss_Item $pItem) {
		$this->_rssItems[] = $pItem;
	}
	
	public function setImage($url, $title, $link) {
		// @todo No images yet :(
	}
	
	/**
	 * @return	string
	 */
	public function render() {
		$pDateNow = new Atom_Date('now');
	
		$rssCode = 
			'<?xml version="1.0" encoding="utf-8"?>'.LF.
			'<rss version="'.self::VERSION.'">'.LF.
			'<channel>'.
				'<title>'.'</title>'.LF.
				'<description>'.'</description>'.LF.
				'<language>'.'</language>'.LF.
				'<pubDate>'.$pDateNow->toRss().'</pubDate>'.LF.
			'</channel>'.LF;
		
		foreach ($this->_rssItems as $curItem) {
			$rssCode .= $curItem->toXml().LF;
		}
		
		$rssCode .= '</channel>';
		
		return $rssCode;
	}
}
