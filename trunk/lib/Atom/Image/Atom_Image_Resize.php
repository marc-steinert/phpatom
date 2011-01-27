<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Used to resize images.
 * 
 * @uses        GD
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Image_Resize {
    
    /** @var resource */
    private $_image;
    
    /** @var array */
    private $_info;
    
    
    /**
     * 
     * @note
     *  Preserves background transparency, if present.
     * 
     * @param   string $inputPath
     * @return  Atom_Image_Resize
     */
    public function __construct($inputPath) {
        if (!file_exists($inputPath) || !is_readable($inputPath)) {
            throw new Atom_FileNotFoundException(
                __('!filename does not exists or is not readable', array('!filename' => $inputPath))
            );
        }
        
        $this->_image = imagecreatefromstring(file_get_contents($inputPath));
        $this->_info = getimagesize($inputPath);
    }
    
    /**
     * 
     * 
     * @param mixed $length
     * @return Atom_Image_Gd
     */
    public function resizeFixedEdgeLength($length) {
        $origHeight = imagesy($this->_image);
        $origWidth = imagesx($this->_image);
        
        if ($origWidth > $origHeight) {
            // Landscape
            $origRatio = $origHeight / $origWidth;
            $newWidth = $length;
            $newHeigth = $newWidth * $origRatio;
        } else {
            // Portrait
            $origRatio = $origWidth/ $origHeight;
            $newHeigth = $length;
            $newWidth = $newHeigth * $origRatio;
        }
        
        $newImage = imagecreatetruecolor($newWidth, $newHeigth);
        
        // Preserve transparency
        switch ($this->_info[2]) {
            case IMAGETYPE_PNG:
                // Turn off transparency blending (temporarily)
                imagealphablending($newImage, false);
                
                // Create a new transparent color for image
                $color = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                
                // Completely fill the background of the new image with allocated color.
                imagefill($newImage, 0, 0, $color);
                
                // Restore transparency blending
                imagesavealpha($newImage, true);
                break;
                
            case IMAGETYPE_GIF:
                $transIndex = imagecolortransparent($image);
                
                if ($transIndex >= 0) {
                    // Get the original image's transparent color's RGB values
                    $transIndex = imagecolorsforindex($this->_image, $transIndex);
                    
                    // Allocate the same color in the new image resource
                    $transIndex = imagecolorallocate(
                        $newImage, $transIndex['red'], $transIndex['green'], $transIndex['blue']
                    );
                    
                    // Completely fill the background of the new image with allocated color.
                    imagefill($newImage, 0, 0, $transIndex);
                    
                    // Set the background color for new image to transparent
                    imagecolortransparent($newImage, $transIndex);
                }
                break;
        }
        
        imagecopyresampled(
            $newImage, $this->_image, 0, 0, 0, 0,
            $newWidth, $newHeigth, $origWidth, $origHeight
        );
        
        $pImageGd = new Atom_Image_Gd();
        $pImageGd->loadResource($newImage);
        
        return $pImageGd;
    }
}
