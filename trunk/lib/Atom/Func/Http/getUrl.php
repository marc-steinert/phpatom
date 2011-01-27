<?php

function getUrl($url, $username = null, $password = null) {
    $output = '';
    
    if (function_exists('curl_init')) {
        $ch = curl_init();

        if ($username != null && $password != null) {
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Authorization: Basic '.base64_encode($username.':'.$password)
                )
            );
        }
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $output = curl_exec($ch);
        
        curl_close($ch);
    } else if (ini_get('allow_url_fopen') == true) {
        if (!is_null($username) && !is_null($password)) {
            $url = str_replace("://", "://$username:$password@", $url);
        }
        
        $output = file_get_contents($url);
    } else {
        throw new Atom_SystemException();
    }
    
    return $output;
}
