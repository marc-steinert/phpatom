<?php
/**
 * Checks if a user is logged in.
 * 
 * @return  bool
 */
function __isAuthenticated() {
    return Atom_Authentification::isLoggedIn();
}
