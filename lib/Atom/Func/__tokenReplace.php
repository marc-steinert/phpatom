<?php

function __tokenReplace($text, array $substitution) {
    return str_replace(
        array_keys($substitution),
        array_values($substitution),
        $text
    );
}
