<?php
/**
 * Leitet durch das Setzen des HTTP-Antwort-Header
 *  auf eine andere URL um und beendet das Skript.
 *
 * @param string $url
 */
function __redirect($url) {
    __setHeader('Location: '.$url);
    ob_end_clean();
    exit;
}
