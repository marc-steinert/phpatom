<?php

/**
 *
 * Fügt einen HTTP Response Header hinzu
 *
 * @param string $header
 * @param string $replace
 * @param int $responseCode
 *
 */
function __setHeader($header, $replace = false, $responseCode = null) {
    header($header, $replace, $responseCode);
}
