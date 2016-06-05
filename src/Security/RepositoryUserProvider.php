<?php

namespace Coblog\Security;

use Coblog\Storage\Repository;

use Coblog\Security\Exception\UsernameNotFoundException;

class RepositoryUserProvider implements UserProviderInterface
{
    private $userRepository;

    private $usernameField;

    public function __construct(Repository $userRepository, $usernameField)
    {
        $this->userRepository = $userRepository;
        $this->usernameField = $usernameField;
    }

    public function loadUser($username)
    {
        $user = $this->userRepository->findOneBy([$this->usernameField => $username]);
        if (!$user) {
            throw new UsernameNotFoundException('User with username "' . $username . '" not found.');
        }

        return $user;
    }
}
