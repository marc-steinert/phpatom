<?php
/**
 *
 *
 * @param array $array
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function __getArrayValue(array $array, $key, $default = '') {
    if (array_key_exists($key, $array)) {
        return $array[$key];
    }

    return $default;
}
