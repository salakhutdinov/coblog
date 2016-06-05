<?php

namespace Coblog\Security;

interface UserProviderInterface
{
    /**
     * Method returns instance of UserInterface by username
     *
     * @param string $username
     *
     * @return \Coblog\Security\UserInterface
     */
    public function loadUser($username);
}
