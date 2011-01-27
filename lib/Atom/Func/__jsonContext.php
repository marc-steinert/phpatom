<?php
/**
 * 
 * @return  bool
 */
function __jsonContext() {
    if (Atom_Main::instance()->getContext() != Atom_Main::CONTEXT_JSON) {
        __redirect('/');
    }
}
