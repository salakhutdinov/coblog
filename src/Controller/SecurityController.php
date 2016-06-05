<?php

namespace Coblog\Controller;

use Coblog\Http\Request;
use Coblog\Form\Form;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->app['auth_manager']->isLoggedIn()) {
            return $this->app->redirect('/');
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
                    $this->app['auth_manager']->authenticate($data['login'], $data['password']);

                    return $this->app->redirect('/');
                } catch (\Exception $e) {
                    $error = 'Bad credentials';
                }
            }
        }

        return $this->app->render('login.html', 200, [
            'form' => $form,
            'error' => $error,
        ]);
    }

    public function logoutAction()
    {
        $this->app['auth_manager']->logout();

        return $this->app->redirect('/');
    }

}
