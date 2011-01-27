<?php
/**
 * 
 * 
 * @param   string  $uri
 */
function __addScript($uri) {
    Atom_Main::instance()->getParser()->addScript($uri);
}
