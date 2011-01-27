<?php

function __e($text, $substitution = null) {
    echo Atom_Translate::instance()->translateString($text, $substitution);
}
