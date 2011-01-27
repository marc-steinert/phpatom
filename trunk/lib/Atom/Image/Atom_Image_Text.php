<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Converts a string into an Image.
 * 
 * @uses        GD
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Image_Text {
	
	/**
	 * Text that will be displayed in the image.
	 *
	 * @var		string
	 */
	private $_text;
	
	/**
	 *
	 */
	private $_backgroundColor = array(
		'r' => 255, 'g' => 255, 'b' => 255
	);
	
	/**
	 *
	 */
	private $_foregroundColor = array(
		'r' => 0, 'g' => 0, 'b' => 0
	);
	
    
    /**
     * 
     * 
     * @param   string  $text   Text to be displayed in the generated image
     * @return  Atom_Image_Text
     */
	public function __construct($text) {
		$this->_text = $text;
	}
	
    /**
     * Sets the background color
     * 
     * @param   int     $red
     * @param   int     $green
     * @param   int     $blue
     */
	public function setBackgroundColor($red, $green, $blue) {
		$this->_backgroundColor = array(
			'r' => (int) $red,
			'g' => (int) $green,
			'b' => (int) $blue
		);
	}
	
    /**
     * Sets the font color
     * 
     * @param   int     $red
     * @param   int     $green
     * @param   int     $blue
     */
	public function setForegroundColor($red, $green, $blue) {
		$this->_foregroundColor = array(
			'r' => (int) $red,
			'g' => (int) $green,
			'b' => (int) $blue
		);
	}
	
    /**
     * @return  resource
     */
	public function getImage() {
		$image = imagecreate(8 * strlen($this->_text) , 20);
		
		$background = imagecolorallocate(
			$image,
			$this->_backgroundColor['r'],
			$this->_backgroundColor['g'],
			$this->_backgroundColor['b']
		);
		
		$black = imagecolorallocate($image, 0, 0, 0);
		return imagestring($image, 4, 1, 2, $this->_text, $black);
	}
	
    /**
     * Sets headers and displays the image
     * 
     * @note    This method does not exit() after output
     * 
     */
	public function output() {
		$image = $this->getImage();
	
		Header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
}
