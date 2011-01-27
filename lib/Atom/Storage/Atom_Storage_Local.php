<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * Storage system for local filesystems based on a key value store.
 * 
 * @uses        Atom_Storage_IAdapter
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Storage_Local implements Atom_Storage_IAdapter {
    
    /** @var string */
    private $_storagePath;
    
    
    /**
     * 
     * 
     * @param   string  $storagePath
     * @return  Atom_Storage_Local
     */
    public function __construct($storagePath) {
        $this->_storagePath = __dir($storagePath);
        
        if (!file_exists($this->_storagePath) || !is_dir($this->_storagePath)) {
            throw new Atom_Storage_Exception(__(
                    'File "!dir" does not exists, or is not a directory',
                    array('!dir' => $this->_storagePath)
            ));
        }
        
        if (!is_writeable($this->_storagePath)) {
            throw new Atom_Storage_Exception(
                __('Storage path is not writeable.')
            );
        }
    }
    
    /**
     * @return string
     */
    public function getStoragePath() {
        return $this->_storagePath;
    }
    
    /**
     * 
     * 
     * @throws  Atom_FileNotFoundException
     * 
     * @param   string      $class
     * @param   string|int  $key
     * @return  string
     */
    public function get($class, $key) {
        $bins = self::getBins($class, $key);
        $path = sprintf(
            '%s/%s/%s',
            $this->_storagePath,
            implode('/', $bins),
            $key
        );
        
        if (!file_exists($path)) {
            throw new Atom_FileNotFoundException(
                __(
                    'File with key "!key" not found.',
                    array('!key' => $key)
                )
            );
        }
        
        return $path;
    }
    
    /**
     * 
     * @throws  Atom_Storage_Exception
     * 
     * @param   mixed   $key
     * @param   string  $path
     */
    public function save($class, $key, $src) {
        if (!file_exists($src)) {
            throw new Atom_Storage_Exception(
                __('File "!file" does not exist.', array('!file' => $src))
            );
        }
        
        if (!is_readable($src)) {
            throw new Atom_Storage_Exception(
                __('File "!file" is not readable.', array('!file' => $src))
            );
        }
        
        $binPath = $this->prepareBin($class, $key);
        copy($src, $binPath.$key);
    }
    
    /**
     * 
     * 
     * @param   mixed   $key
     */
    public function delete($class, $key) {
        
    }
    
    /**
     * 
     * 
     * @param   mixed   $key
     * @return  bool
     */
    public function exists($class, $key) {
        // @todo
    }
    
    private function getClassPath($class) {
        return $this->_storagePath.$class.'/';
    }
    
    /**
     * 
     * 
     * @param mixed $class
     * @param mixed $key
     */
    private function prepareBin($class, $key) {
        $bins = self::getBins($class, $key);
        array_unshift($bins, $this->_storagePath);
        
        $fullPath = '';
        
        while ($bin = array_shift($bins)) {
            $fullPath .= __dir($bin);
            
            if (!file_exists($fullPath)) {
                mkdir($fullPath);
            }
        }
        
        return $fullPath;
    }
    
    /**
     * 
     * 
     * @param   mixed   $key
     * @return  array
     */
    private static function getBins($class, $key) {
        $md5 = md5($key);
        
        return array(
            $class, $md5{0}, $md5{1}, $md5{2}
        );
    }
}