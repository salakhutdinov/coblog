<?php

namespace Coblog;

use Coblog\Http\Request;
use Coblog\Http\Response;
use Coblog\Http\RedirectResponse;
use Coblog\Http\Route;

class Kernel extends Container
{
    /**
     * Application config.
     *
     * @var array
     */
    private $config;

    /**
     * Array of application routes.
     *
     * @var array
     */
    private $routes = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->init();
    }

    /**
     * Returns array of providers.
     *
     * @return array
     */
    public function registerProviders()
    {
        return [];
    }

    protected function init()
    {
        $providers = $this->registerProviders();
        foreach ($providers as $provider) {
            $provider->register($this);
        }
    }

    /**
     * @return array
     */
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

    /**
     * Handling request and return Response object.
     *
     * @param \Coblog\Http\Request $request
     * @return \Coblog\Http\Response
     * @throws \Exception
     */
    public function handle(Request $request)
    {
        try {
            $route = $this->matchRoute($request);
            $controller = $route->getController();

            preg_match($route->getRegex(), $request->getUri(), $matches);

            $arguments = [];
            if ($controller instanceof \Closure) {
                $reflection = new \ReflectionFunction($controller);
            } else {
                $reflection = new \ReflectionMethod($controller[0], $controller[1]);
            }

            $parameters = $reflection->getParameters();
            foreach ($parameters as $parameter) {
                if ($class = $parameter->getClass()) {
                    if (is_a($request, $class->getName())) {
                        $arguments[] = $request;
                    } else {
                        throw new \Exception('Could not provide parameter with ' . $class->getName() . ' class.', 400);
                    }
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

    /**
     * Handling exception.
     *
     * @param \Exception $exception
     * @return \Coblog\Http\Response
     */
    public function handleException(\Exception $exception)
    {
        return $this->render('error.html', $exception->getCode() ?: 500, [
            'exception' => $exception,
        ]);
    }

    /**
     * Run application to handle request.
     */
    public function run()
    {
        $request = Request::createFromGlobals();
        $response = $this->handle($request);
        $response->send();
    }

    /**
     * Rendering template and returns template output.
     *
     * @param string $template
     * @param array $parameters
     * @return string
     * @throws \Exception
     */
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

    /**
     * Return response with redirect header.
     *
     * @param type $url
     * @return \Coblog\Http\RedirectResponse
     */
    public function redirect($url)
    {
        return new RedirectResponse($url);
    }

    /**
     * Rendering template and returns Response object.
     *
     * @param string $template
     * @param int $statusCode
     * @param array $parameters
     * @return \Coblog\Http\Response
     */
    public function render($template, $statusCode = 200, array $parameters = [])
    {
        $content = $this->renderTemplate($template, $parameters);

        return new Response($content, $statusCode, ['Content-type' => 'text/html']);
    }

    /**
     * Registering a controller with route.
     *
     * @param string $url
     * @param array $methods
     * @param callable $controller
     */
    public function request($url, array $methods, callable $controller)
    {
        $route = new Route($url, $methods, $controller);

        $this->routes[] = $route;
    }

    /**
     * Registering a controller with GET method.
     *
     * @param string $url
     * @param callable $controller
     */
    public function get($url, callable $controller)
    {
        $this->request($url, [Request::METHOD_GET], $controller);
    }

    /**
     * Registering a controller with POST method.
     *
     * @param string $url
     * @param callable $controller
     */
    public function post($url, callable $controller)
    {
        $this->request($url, [Request::METHOD_GET], $controller);
    }
}
