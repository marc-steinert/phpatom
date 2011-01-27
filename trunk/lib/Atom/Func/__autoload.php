<?php
/**
 *
 *
 * @param string $className
 */
function __autoload($className) {
    throw new Atom_SystemException('Depreciated call to __autoload');
}