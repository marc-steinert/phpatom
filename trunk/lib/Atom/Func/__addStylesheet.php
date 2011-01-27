<?php
/**
 * 
 * 
 * @param   string  $uri
 */
function __addStylesheet($uri) {
    Atom_Main::instance()->getParser()->addStylesheet($uri);
}
