<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Wrapper for importing and displaying GD images
 * 
 * @uses        GD
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Image_Gd {

    const TYPE_JPEG = 0;
    const TYPE_PNG = 1;
    const TYPE_GIF = 2;

    /** @var resource */
    private $_image;

    /** @var int */
    private $_width;

    /** @var int */
    private $_height;

    /** @var int */
    private $_type;

    /**
     * Mimetype of the image.
     * 
     * @var string
     */
    private $_mime;


    public function __construct() { }

    /**
     *
     * @throws  Atom_Image_Exception
     *
     * @param   resource    $image
     */
    public function loadResource($image) {
        if (!is_resource($image) || get_resource_type($image) != 'gd') {
            throw new Atom_Image_Exception();
        }

        $this->_image = $image;
        $this->_width = imagesx($image);
        $this->_heigth = imagesx($image);
    }

    /**
     *
     * @throws  Atom_Image_Exception
     *
     * @param   resource $image
     */
    public function loadFile($filename) {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Atom_Image_Exception();
        }

        $info = getimagesize($filename);
        $this->_width = $info[0];
        $this->_height = $info[1];

        $this->_type = image_type_to_extension($info[2], false);
        $this->_mime = $info['mime'];

        if ($this->_type == 'jpeg' && (imagetypes() & IMG_JPG)) {
            $image = imagecreatefromjpeg($filename);
        } else if ($this->_type == 'png' && (imagetypes() & IMG_PNG)) {
            $image = imagecreatefrompng($filename);
        } else if ($this->_type == 'gif' && (imagetypes() & IMG_PNG)) {
            $image = imagecreatefrompng($filename);
        } else {
            throw new Atom_Image_Exception();
        }

        $this->loadResource($image);
    }

    /**
     * 
     * 
     * @throws  Atom_Image_Exception
     * 
     * @param   string  $filename
     * @param   int     $type
     * @return  bool
     */
    public function save($filename, $type) {
        $success = false;

        switch ($type) {
            case self::TYPE_GIF:
                $success = imagegif($this->_image, $filename);
                break;
            case self::TYPE_JPEG:
                $success = imagejpeg($this->_image, $filename);
                break;
            case self::TYPE_PNG:
                $success = imagepng($this->_image, $filename);
                break;
            default:
                throw new Atom_Image_Exception('Undefined type');
        }

        return $success;
    }
    
    /**
     * 
     * 
     * @throws  Atom_Image_Exception
     *  
     * @param   int   $type
     * @param   bool  $exit
     */
    public function display($type, $exit = true) {
        switch ($type) {
            case self::TYPE_GIF:
                header('Content-Type: image/gif');
                imagegif($this->_image);
                break;
            case self::TYPE_JPEG:
                header('Content-Type: image/jpeg');
                imagejpeg($this->_image);
                break;
            case self::TYPE_PNG:
                header('Content-Type: image/png');
                imagepng($this->_image);
                break;
            default:
                throw new Atom_Image_Exception('Undefined type');
        }

        $exit && exit;
    }
}