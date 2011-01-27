<?php
/**
 * Atom framework
 * 
 * @version $Id$
 * @copyright Marc Steinert
 */
 
/**
 * Client for retrieving Twitter status updates
 * 
 * @uses        curl
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
class Twitter_Api {
 
	/** @var string */
	const BASE_URL = 'http://www.twitter.com';
 
	/** @var string */
	private $_username;
 
	/** @var string */
	private $_password;
 
 
	/**
	 * @param	string	$username	Twitter account username
	 * @param	string	$password	Twitter account password
	 */
	public function __construct($username, $password) {
		$this->_username = $username;
		$this->_password = $password;
	}
 
	/**
	 * Gets the last status updates as array
	 * 
	 * @param	string	$user Twitter username
	 * @param	int		$count
	 * @return	array	Two dimensional array, containing status updates
	 */
	public function getStatus($user, $count = 4) {
        $xmlReply = $this->dispatchApiCall('/statuses/user_timeline/'.urlencode($user).'.xml?count='.(int)$count);
        
        $status = array();
        
        if ($xmlReply !== null) {
        	foreach($xmlReply->status as $curStatus) {
        		$status[] =
        			array(
        				'text' => (string) $curStatus->text,
        				'date' => substr((string) $curStatus->created_at, 0, 16),
        				'id' => (string) $curStatus->id,
        				'screen_name' => $curStatus->user->screen_name
        			);
        	}
        }
        
        return $status;
    }
 
    /**
     * Sends an API request to the Twitter servers via curl
	 *
     * @param	string				$targetPath	Uri Path
     * @return	SimpleXMLElement
     */
	protected function dispatchApiCall($targetPath) {
		$curl = curl_init(self::BASE_URL.$targetPath);
 
		curl_setopt($curl, CURLOPT_USERPWD, $this->_username.':'.$this->_password);
 
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_NOBODY, 0);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, "Some user agent");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, "headers");
 
        $response = curl_exec($curl);
        $responseInfo = curl_getinfo($curl);
        curl_close($curl);
 
        if (parseInt($responseInfo['http_code']) == 200 ) {
			return new SimpleXMLElement($response);
        } else {
            return null;
        }
	}
}
