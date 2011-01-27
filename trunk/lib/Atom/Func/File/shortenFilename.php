<?php
/**
 * Verkuerzt einen Dateinamen ohne die Dateiendung zu verlieren.
 * 
 * @example
 *  $filename = 'veryverylongtitle.doc';
 *  echo shortenFilename($filename, 10);
 *  // Ausgabe: "veryve.doc"
 * 
 * @param string $filename
 * @param int $maxlength
 */
function shortenFilename($filename, $maxlength) {
    $shortened = $filename;
    
    if (mb_strlen($filename) > $maxlength) {
        $tmp = explode('.', $filename);
        $extension = array_pop($tmp);
        
        $newBasename = mb_substr(
            $filename,
            0,
            $maxlength - mb_strlen($extension) - 1 // -1 wg. "."
        );
        
        $shortened = $newBasename.'.'.$extension;
    }
    
    return $shortened;    
}