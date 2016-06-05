<?php

namespace Coblog\Provider;

use Coblog\ServiceProviderInterface;
use Coblog\Container;
use Coblog\Security\RepositoryUserProvider;
use Coblog\Security\AuthManager;
use Coblog\Security\PlainPasswordEncoder;
use Coblog\Model\User;

class SecurityProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $userRepository = $container['document_manager']->getRepository(User::class);
        $userProvider = new RepositoryUserProvider($userRepository, 'email');
        $passwordEncoder = new PlainPasswordEncoder;
        $authManager = new AuthManager($userProvider, $passwordEncoder);
        $container['auth_manager'] = $authManager;
    }
}
