<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Wrapper for the Google Geo Code API
 * 
 * @uses        curl
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Atom_Google_GeoCode {
    
    private $_googleMapsKey;
    
    
    public function __construct($googleMapsKey) {
        $this->_googleMapsKey = $googleMapsKey;
    }
    
    /**
     * Encodes an address represented by string into lat/lng coordinates.
     * 
     * @param   string $address
     * @param   string $googleMapsKey
     * @param   string $output          Output type, csv or xml are valid arguments.
     * @return  array|string
     */
    public static function addressToCoords($address, $output = 'csv') {
        __func('Http/getUrl');
        
        $address = urlencode($address);
        $googleMapsKey = urlencode($googleMapsKey);
        $data = getUrl('http://maps.google.com/maps/geo?q='.$address.'&key='.$googleMapsKey.'&output='.$output);

        $out = '';
        
        switch ($output) {
            case 'csv':
                $out = explode(',', $data); // HTTP status code, accuracy bit, latitude, longitude
                break;
            case 'xml':
                $xml = simplexml_load_string($data);
                
                if ($xml === false || $xml->Response->Status->code != '200') {
                    $out = false;
                } else {
                    explode(',', (string) $xml->Response->Placemark->Point->coordinates); // latitude, longitude, ???
                }
                break;
            default:
                $out = $data;
        }
        
        return $out;
    }
}