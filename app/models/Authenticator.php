<?php

/**
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name Authentication class
 * - reimplementation of Nette\Security\IAuthenticator
 * - user's credentials have to match a database record
 * @todo passwords are salted and hashed using sha1 for better security (after registration is done)
 */

use Nette\Security as NS;

class Authenticator extends Nette\Object implements NS\IAuthenticator {

    public function authenticate(array $credentials) {

        list($user, $pass) = $credentials;
        $result = dibi::fetch('SELECT * FROM [nts_players] WHERE [username]=%s', $user);

        if (!$result) {
            throw new NS\AuthenticationException("User '$user' not found.", self::IDENTITY_NOT_FOUND);
        }

        if ($result->password !== $this->calculateHash($pass)) {
            throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
        }

        unset($result->password);
        return new NS\Identity($result->id, $result->role, $result->toArray());
    }

    /**
     * Computes salted password hash.
     * @param  string
     * @return string
     */
    public function calculateHash($password) {
        //return md5($password . str_repeat('*enter any random salt here*', 10));
        return sha1($password);
    }

}
