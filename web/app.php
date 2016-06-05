<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

use Coblog\Http\Request;
use Coblog\Model\Post;
use Coblog\Form\Form;
use Coblog\Provider\StorageProvider;
use Coblog\Provider\SecurityProvider;

require __DIR__ . '/../src/autoload.php';

$config = require __DIR__ . '/../var/config/config.php';

$app = new Coblog\App($config);

$app->register(new StorageProvider);
$app->register(new SecurityProvider);

$app->get('/', function (Request $request) use ($app) {
    $postRepository = $app['document_manager']->getRepository(Post::class);
    $posts = $postRepository->findAll();

    return $app->render('index.html', 200, [
        'posts' => $posts,
    ]);
});

$app->request('/new', [Request::METHOD_GET, Request::METHOD_POST], function (Request $request) use ($app) {
    if (!$app['auth_manager']->isLoggedIn()) {
        return $this->redirect('/');
    }

    $form = new Form(['action' => '/new', 'method' => Request::METHOD_POST]);
    $form->addField('title', 'text', ['required' => true]);
    $form->addField('text', 'textarea', ['required' => true]);

    if ($request->isMethod(Request::METHOD_POST)) {
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $post = new Post($app['auth_manager']->getCurrentUser(), $data['title'], $data['text']);

            $app['document_manager']->save($post);

            return $app->redirect('/post/' . $post->getId());
        }
    }

    return $app->render('new.html', 200, ['form' => $form]);
});

$app->get('/post/{postId}', function (Request $request, $postId) {
    $postRepository = $app['document_manager']->getRepository(Post::class);
    $commentRepository = $app['document_manager']->getRepository(Comment::class);

    $post = $postRepository->find($postId);
    $comments = $commentRepository->findBy([
        'postId' => $postId,
    ]);

    return $app->render('post.html', 200, [
        'post' => $post,
        'comments' => $comments,
    ]);
});

$app->request('/login', [Request::METHOD_GET, Request::METHOD_POST], function (Request $request) use ($app) {
    if ($app['auth_manager']->isLoggedIn()) {
        return $this->redirect('/');
    }

    $form = new Form(['action' => '/login', 'method' => Request::METHOD_POST]);
    $form->addField('login', 'text', ['required' => true]);
    $form->addField('password', 'password', ['required' => true]);
    $error = null;

    if ($request->isMethod(Request::METHOD_POST)) {
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                $app['auth_manager']->authenticate($data['login'], $data['password']);

                return $app->redirect('/');
            } catch (\Exception $e) {
                $error = 'Bad credentials';
            }
        }
    }

    return $app->render('login.html', 200, [
        'form' => $form,
        'error' => $error,
    ]);
});

$app->get('/logout', function () use ($app) {
    $app['auth_manager']->logout();

    return $app->redirect('/');
});

$app->run();
