<?php
/**
 * Atom framework
 *
 * @version $Id$
 * @copyright Marc Steinert
 */

/**
 * 
 *
 * @package     Atom Framework
 * @author      Marc Steinert <marc@bithub.net>
 */
final class Atom_Authentification {

    /**
     * @note    You should change the salt to an own, uniqe one.
     *
     * @var     string
     */
    const PASSWORD_SALT = 'y4357m2d3';

    /** @var string */
    const SESSION_USER_KEY = 'user';


    /**
     * Sets $user as currently logged in user.
     *
     * @param   Atom_IUser  $user
     */
    public static function setLoggedInUser(Atom_IUser $user) {
        $_SESSION[self::SESSION_USER_KEY] = serialize($user);
    }

    /**
     * Returns the currently logged in user.
     *
     * @return  Atom_IUser
     */
    public static function getLoggedInUser() {
        return unserialize($_SESSION[self::SESSION_USER_KEY]);
    }

    /**
     * Removes currently logged in user (logout).
     *
     */
    public static function removeLoggedInUser() {
        unset($_SESSION[self::SESSION_USER_KEY]);
    }

    /**
     * Tests, if the visitor is logged in.
     *
     * @return bool
     */
    public static function isLoggedIn() {
        return (array_key_exists(self::SESSION_USER_KEY, $_SESSION));
    }

    /**
     * Calculates a salted md5 hash for a plain
     *  text password.
     *
     * @param   string  $password
     * @return  string
     */
    public static function getHashedPassword($password) {
        return md5($password.self::PASSWORD_SALT);
    }

    public static function getUserByCredentials($email, $password, $userclassName) {
        if (!class_exists($userclassName)) {
            throw new Atom_SystemException('User class not found.');
        }

        $rslt = __db()->select(
            $userclassName::getTablename(),
            array(
                'Email' => $email,
                'Password' => self::getHashedPassword($password)
            )
        );

        $pUser = null;

        if (count($rslt) == 1) {
            $pUser = new $userclassName((int) $rslt['Id']);
        }

        return $pUser;
    }
}
