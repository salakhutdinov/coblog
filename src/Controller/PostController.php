<?php

namespace Coblog\Controller;

use Coblog\Http\Request;
use Coblog\Form\Form;
use Coblog\Model\Post;
use Coblog\Model\Comment;

class PostController extends Controller
{
    public function listAction(Request $request)
    {
        $postRepository = $this->app['document_manager']->getRepository(Post::class);
        $posts = $postRepository->findBy([], [
            'createdAt' => -1,
        ]);

        return $this->app->render('index.html', 200, [
            'posts' => $posts,
        ]);
    }

    public function newAction(Request $request)
    {
        if (!$this->app['auth_manager']->isLoggedIn()) {
            return $this->app->redirect('/');
        }

        $form = new Form(['action' => '/new', 'method' => Request::METHOD_POST]);
        $form->addField('title', 'text', ['required' => true]);
        $form->addField('text', 'textarea', ['required' => true]);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $post = new Post($this->app['auth_manager']->getCurrentUser(), $data['title'], $data['text']);

                $this->app['document_manager']->save($post);

                return $this->app->redirect('/post/' . $post->getId());
            }
        }

        return $this->app->render('new.html', 200, ['form' => $form]);
    }

    public function viewAction(Request $request, $postId)
    {
        $postRepository = $this->app['document_manager']->getRepository(Post::class);
        $commentRepository = $this->app['document_manager']->getRepository(Comment::class);

        $post = $postRepository->find($postId);
        if (!$post) {
            throw new \Exception('Could not find post.', 404);
        }
        $comments = $commentRepository->findBy([
            'postId' => $postId,
        ], [
            'createdAt' => -1,
        ]);

        $form = new Form(['action' => '/post/' . $post->getId(), 'method' => Request::METHOD_POST]);
        $form->addField('author', 'text', ['required' => true]);
        $form->addField('text', 'text', ['required' => true]);
        $error = null;

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $comment = new Comment($post, $data['author'], $data['text']);
                $this->app['document_manager']->save($comment);

                return $this->app->redirect('/post/' . $post->getId());
            }
        }

        return $this->app->render('post.html', 200, [
            'post' => $post,
            'comments' => $comments,
            'form' => $form,
        ]);
    }
}
