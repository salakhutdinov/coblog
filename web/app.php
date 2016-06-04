<?php

ini_set('display_errors', true);
ini_set('error_reporting', E_ALL);

use Coblog\Http\Request;
use Coblog\Model\Post;
use Coblog\Form\Form;
use Coblog\Provider\StoreProvider;

require __DIR__ . '/../src/autoload.php';

$config = require __DIR__ . '/../var/config/config.php';

$app = new Coblog\App($config);

$app->register(new StoreProvider);
//$app->register(new SecurityProvider);

$app->get('/', function (Request $request) use ($app) {
    $postRepository = $app['document_manager']->getRepository(Post::class);
    $posts = $postRepository->findAll();

    return $app->render('index.html', 200, [
        'posts' => $posts,
    ]);
});

$app->request('/new', [Request::METHOD_GET, Request::METHOD_POST], function (Request $request) use ($app) {
    $form = new Form(['action' => '/new', 'method' => Request::METHOD_POST]);
    $form->addField('text', 'textarea', ['required' => true]);

    if ($request->isMethod(Request::METHOD_POST)) {
        $form->bindRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $post = new Post(null, $data['']);

            $postManager = $app['store']->getManager('Post');
            $postManager->save($post);

            return new RedirectResponse('/post/' . $post->getId());
        }
    }

    return $app->render('new.html', 200, ['form' => $form]);
});

$app->get('/post/{postId}', function (Request $request, $postId) {
    $postRepository = $app['store']->getRepository(Post::class);
    $commentRepository = $app['store']->getRepository(Comment::class);

    $post = $postRepository->find($postId);
    $comments = $commentRepository->findBy([
        'postId' => $postId,
    ]);

    return $app->render('post.html', [
        'post' => $post,
        'comments' => $comments,
    ]);
});

$app->get('/auth', function () {

});

$app->run();
