<?php

namespace Coblog;

use Coblog\Http\Request;
use Coblog\Http\Response;
use Coblog\Http\RedirectResponse;
use Coblog\Http\Route;

class App extends Container
{
    private $config;

    private $routes = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    private function matchRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if (!preg_match($route->getRegex(), $request->getUri())) {
                continue;
            }

            if (!in_array($request->getMethod(), $route->getMethods())) {
                continue;
            }

            return $route;
        }

        throw new \Exception('Route for uri "' . $request->getUri() . '" not found', 404);
    }

    public function handle(Request $request)
    {
        try {
            $route = $this->matchRoute($request);
            $controller = $route->getController();

            preg_match($route->getRegex(), $request->getUri(), $matches);

            $arguments = [];
            $reflection = new \ReflectionFunction($controller);
            $parameters = $reflection->getParameters();
            foreach ($parameters as $parameter) {
                if ($class = $parameter->getClass()) {
                    if (is_a($request, $class->getName())) {
                        $arguments[] = $request;
                    } else {
                        $arguments[] = null;                    }
                } elseif (isset($matches[$parameter->getName()])) {
                    $arguments[] = $matches[$parameter->getName()];
                } else {
                    $arguments[] = null;
                }
            }

            
            $response = call_user_func_array($controller, $arguments);

            return $response;
        } catch (\Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    public function handleException(\Exception $exception)
    {
        return $this->render('error.html', $exception->getCode() ?: 500, [
            'exception' => $exception,
        ]);
    }

    public function run()
    {
        $request = Request::createFromGlobals();
        $response = $this->handle($request);
        $response->send();
    }

    public function renderTemplate($template, array $parameters = [])
    {
        $fileName = $this->config['views_dir'] . '/' . $template . '.php';
        if (!file_exists($fileName)) {
            throw new \Exception('Template "' . $template . '" not found by path "' . $fileName . '".');
        }
        ob_start();
        extract(array_merge([
            'app' => $this,
        ], $parameters));
        require $fileName;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function redirect($url)
    {
        return new RedirectResponse($url);
    }

    public function render($template, $statusCode = 200, array $parameters = [])
    {
        $content = $this->renderTemplate($template, $parameters);

        return new Response($content, $statusCode, ['Content-type' => 'text/html']);
    }

    public function request($url, array $methods, $controller, array $attributes = [])
    {
        $route = new Route($url, $methods, $controller, $attributes);

        $this->routes[] = $route;
    }

    public function get($url, $controller, array $attributes = [])
    {
        return $this->request($url, [Request::METHOD_GET], $controller);
    }

    public function post($url, $controller, array $attributes = [])
    {
        return $this->request($url, [Request::METHOD_GET], $controller);
    }
}
