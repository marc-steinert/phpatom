<?php
/**
 * Removes all non-printable chars
 * 
 * @param string $string
 * @param mixed $trim
 * @return mixed
 */
function __clean($string, $trim = true) {
    if ($trim) {
        $string = trim($string);
    }
    
    return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string);
}
