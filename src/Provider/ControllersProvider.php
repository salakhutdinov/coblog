<?php

namespace Coblog\Provider;

use Coblog\ServiceProviderInterface;
use Coblog\Container;
use Coblog\Controller\SecurityController;
use Coblog\Controller\PostController;
use Coblog\Http\Request;

class ControllersProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $securityController = new SecurityController($container);
        $app = $container;
        $app->request('/login', [Request::METHOD_GET, Request::METHOD_POST], [$securityController, 'loginAction']);
        $app->get('/logout', [$securityController, 'logoutAction']);

        $postController = new PostController($app);
        $app->get('/', [$postController, 'listAction']);
        $app->request('/new', [Request::METHOD_GET, Request::METHOD_POST], [$postController, 'newAction']);
        $app->request('/post/{postId}', [Request::METHOD_GET, Request::METHOD_POST], [$postController, 'viewAction']);
    }
}
