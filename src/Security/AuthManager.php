<?php

namespace Coblog\Security;

use Coblog\Security\Exception\UsernameNotFoundException;
use Coblog\Security\Exception\BadCredentialsException;

class AuthManager
{
    private $passwordEncoder;

    private $userProdiver;

    private $currentUser;

    public function __construct(UserProviderInterface $userProvider, PasswordEncoderInterface $passwordEncoder)
    {
        $this->userProvider = $userProvider;
        $this->passwordEncoder = $passwordEncoder;
        $this->init();
    }

    private function init()
    {
        session_start();
        if (isset($_SESSION['_username'])) {
            try {
                $username = $_SESSION['_username'];
                $user = $this->userProvider->loadUser($username);
                $this->currentUser = $user;
            } catch (UsernameNotFoundException $e) {
                unset($_SESSION['_username']);
            }
        }
    }

    public function authenticate($username, $password)
    {
        $user = $this->userProvider->loadUser($username);
        if ($this->passwordEncoder->isPasswordValid($user->getPassword(), $password)) {
            $_SESSION['_username'] = $user->getUsername();
            $this->currentUser = $user;
        } else {
            throw new BadCredentialsException;
        }
    }

    public function logout()
    {
        unset($_SESSION['_username']);
        $this->currentUser = null;
    }

    public function isLoggedIn()
    {
        return !is_null($this->currentUser);
    }

    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
