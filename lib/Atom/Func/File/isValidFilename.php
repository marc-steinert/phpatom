<?php
/**
 * 
 * 
 * @param   string  $filename
 * @return  bool
 */
function isValidFilename($filename) {
    return true;
    $parts = preg_split("/(\/|".preg_quote("\\").")/", $filename);
    
    if (preg_match("/[a-z]:/i",$parts[0])) {
       unset($parts[0]);
    }
    
    foreach ($parts as $part) {
       if (
          preg_match("/[".preg_quote("^|?*<\":>","/")."\a\b\c\e\x\v\s]/", $part)||
          preg_match("/^(PRN|CON|AUX|CLOCK$|NUL|COMd|LPTd)$/im", str_replace(".","\n", $part))
       ) {
          return false;
       }
    }
    
    return true;
}
