<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Represents an email address
 * 
 * @uses        Atom_Exception
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Email_Address implements Atom_Db_ISQLValue {
    
    /** @var string */
    private $_address;
    
    
    /**
     * 
     * @throws  Atom_ArgumentException
     * 
     * @param   string  $address
     * @param   bool  $checkMxRecord    Check also for valid MX record?
     * @return  Atom_Email_Address
     */
    public function __construct($address, $checkMxRecord = false) {
        $address = __clean($address);
        
        if ($address == '') {
            throw new Atom_ArgumentException(
                __('Email address is empty')
            );    
        }
        
        if (!self::validate($address)) {
            throw new Atom_ArgumentException(
                __(
                    '%address is not a valid email address.',
                    array('%address' => $address)
                )
            );
        }
        
        if ($checkMxRecord) {
            list(, $domain) = explode('@', $this->_address);
            
            $mxhosts = array();
            
            if (!getmxrr($domain, $mxhosts)) {
                throw new Atom_ArgumentException(
                    __('No valid mx record found.')
                );
            }
        }
        
        $this->_address = $address;
    }
    
    /**
     * @return   string
     */
    public function toString() {
        return $this->_address;
    }
    
    /**
     * @return   string
     */
    public function toSql() {
        return __escape($this->toString());
    }
    
    /**
     * Checks, if email address is valid
     * 
     * @param   string  $address
     * @return  bool
     */
    public static function validate($address) {
        return (bool) preg_match(
            '/^([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*[\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)$/i',
            $address
        );
    }
    
    /**
     * Obfuscates an email address for spambot protection.
     * 
     * @see http://www.celticproductions.net/articles/10/email/php+email+obfuscator.html
     * 
     * @return  string
     */
    public function munge() {
        $address = strtolower($this->_address);
        $coded = '';
        $unmixedkey = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.@';
        $inprogresskey = $unmixedkey;
        $mixedkey = '';
        
        $unshuffled = strlen($unmixedkey);
        
        for ($i = 0; $i <= strlen($unmixedkey); $i++) {
            $ranpos = rand(0,$unshuffled-1);
            $nextchar = $inprogresskey{$ranpos};
            $mixedkey .= $nextchar;
            $before = substr($inprogresskey, 0, $ranpos);
            $after = substr(
                $inprogresskey,
                $ranpos + 1,
                $unshuffled - ($ranpos+1)
            );
            
            $inprogresskey = $before.''.$after;
            $unshuffled -= 1;
        }
    
        $cipher = $mixedkey;
        $shift = strlen($address);

        $txt = "<script type=\"text/javascript\" language=\"javascript\">\n" .
            "<!-"."-\n";

        for ($j = 0; $j < strlen($address); ++$j) {
            if (strpos($cipher, $address{$j}) == -1) {
                $chr = $address{$j};
                $coded .= $address{$j};
            } else {
                $chr = (strpos($cipher, $address{$j}) + $shift) % strlen($cipher);
                $coded .= $cipher{$chr};
            }
        }

        $txt .= "\ncoded = \"" . $coded . "\"\n" .
            "  key = \"".$cipher."\"\n".
            "  shift=coded.length\n".
            "  link=\"\"\n".
            "  for (i=0; i<coded.length; i++) {\n" .
            "    if (key.indexOf(coded.charAt(i))==-1) {\n" .
            "      ltr = coded.charAt(i)\n" .
            "      link += (ltr)\n" .
            "    }\n" .
            "    else {     \n".
            "      ltr = (key.indexOf(coded.charAt(i))- shift+key.length) % key.length\n".
            "      link += (key.charAt(ltr))\n".
            "    }\n".
            "  }\n".
            "document.write(\"<a href='mailto:\"+link+\"'>\"+link+\"</a>\")\n".
            "\n".
            "//-"."->\n".
            "<" . "/script><noscript>N/A".
            "<"."/noscript>";
        
        return $txt;
    }
}
