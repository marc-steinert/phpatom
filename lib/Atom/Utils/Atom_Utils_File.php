<?php

class Atom_Utils_File {
    
    /**
     * Enforce static behavior.
     * 
     */
    private function __construct() { }
    
    /**
     * Gets the extension of a file.
     * 
     * @param   string  $filename
     * @return  string
     */
    public static function getExtension($filename) {
        $ext = '';
        
        if (($pos = strrpos($path, '.')) !== false) {
            $ext = substr($filename, $pos + 1);
        }
        
        return $ext;
    }
    
    public static function getMimeType($filename) {
        $mimetype = '';
        
        if (function_exists('finfo_open')) {
            $info = finfo_open(FILEINFO_MIME_TYPE);
            
            if (!$info) {
                
            }
            
            $mimetype = $info->file($filename);
        } else if (function_exists('mime_content_type')) {
            $mimetype = mime_content_type($filename);
        }
        
        return $mimetype;
    }
}
