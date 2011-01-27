<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Gets thrown by the CMS subsystem if a requested view is missing.
 * 
 * @note
 *  Sets 404 header automatically
 * 
 * @example
 *  http://chart.apis.google.com/chart?&chs=100x150&cht=lc&chco=76A4FB&chd=t:1,112,3,4,5,&chls=2&chma=40,20,20,30
 * 
 * @uses        Atom_Exception
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_Cms_FileNotFoundException extends Atom_Exception {
    
    public function __construct() {
        self::defaultOutput();
    }
    
    private static function defaultOutput() {
        header('HTTP/1.0 404 Not Found');
        
        $html =
<<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>Site not found</title>
</head>
<body>
    Site not found.
</body>
</html>
EOF;

        echo $html;
        exit;
    }
}
