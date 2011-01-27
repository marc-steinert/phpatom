<?php

class Atom_Utils_Array {

    /**
     * Enforce static behaviour
     *
     */
    private function __construct() { }


    /**
     * Returns true, if <code>$array</code is an associative array
     *
     * @param   array   $array
     * @return  bool
     */
    public static function isAssociative(array $array) {
        return count($array) !== array_reduce(
            array_keys($array),
            array('Atom_Utils_Array', 'isAssocCallback'),
            0
        );
    }

    private static function isAssocCallback($a, $b) {
        return $a === $b ? $a + 1 : 0;
    }

    /**
     * Implode array with the ability to define glue, strings before and after each array element.
     *
     * @param   string  $before
     * @param   string  $after
     * @param   string  $glue
     * @param   array   $array
     * @return  string
     */
    public static function extendedImplode($before, $after, $glue, array $array) {
        $output = '';

        foreach($array as $item) {
            $output .= $before . $item . $after . $glue;
        }

        return substr($output, 0, -strlen($glue));
    }
}
