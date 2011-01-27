<?php
/**
 * Gets currently logged in user.
 * 
 * @return  Autarchic_User
 */
function __user() {
    return Atom_Authentification::getLoggedInUser();
}
