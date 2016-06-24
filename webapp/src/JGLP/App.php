<?php

namespace JGLP;

use Smrtr\HaltoRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class App
{
    /**
     * @var App
     */
    private static $instance;

    /**
     * @var Services
     */
    protected $services;

    /**
     * @var HaltoRouter
     */
    protected $router;

    /**
     * @var callable|null
     */
    public $errorHandler;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (! self::$instance instanceof App) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Load service configs and routes.
     *
     * @return $this
     */
    public function bootstrap()
    {
        $this->services = new Services;
        $this->services->loadConfig();

        $this->router = new HaltoRouter;
        $routes = Yaml::parse(file_get_contents(CONFIG_PATH.'/routes.yml'));
        foreach ($routes as $name => $route) {
            $this->router->map(
                $route["method"],
                $route["route"],
                $route["target"],
                $name,
                isset($route["hostgroup"]) ? $route["hostgroup"] : null
            );
        }

        require_once CONFIG_PATH.'/bootstrap.php';

        $this->request = Request::createFromGlobals();
        $this->response = Response::create();

        return $this;
    }

    /**
     * @param string $service
     *
     * @return Service\ServiceInterface|mixed
     */
    public function service($service)
    {
        return $this->services->get($service);
    }

    /**
     * Do routing and execute.
     *
     * @return $this
     */
    public function run()
    {
        $match = $this->router->match(
            $this->request->getPathInfo(),
            $this->request->getMethod(),
            $this->request->getHttpHost()
        );

        // Dispatch
        $this->dispatch($match);

        // Respond
        $this->response->send();

        return $this;
    }

    /**
     * Takes the result of router matching and tries to call a controller action.
     * Sets response code to 404 if no valid match is found.
     *
     * @param mixed $match
     *
     * @return $this
     */
    public function dispatch($match)
    {
        if (is_array($match)) {

            // Check params

            if (is_array($match['params']) && count($match['params'])) {

                // Assign params to request object
                foreach ($match['params'] as $key => $value) {
                    $this->request->attributes->set($key, $value);
                }
            }

            if (is_string($match["target"])) {
                // Unpack a target string of the form Class@method

                list($controller, $action) = explode("@", $match['target'], 2);
                $this->request->attributes->set('controller', $controller);
                $this->request->attributes->set('action', $action);

                // Check controller
                $reflectionClass = new \ReflectionClass($controller);
                if ($reflectionClass->hasMethod($action)) {

                    // Check action
                    $reflectionMethod = $reflectionClass->getMethod($action);
                    if ($reflectionMethod->isPublic()) {

                        // Call action
                        try {
                            $controllerObj = $reflectionClass->newInstance();
                            $reflectionMethod->invoke($controllerObj);
                        }
                        catch (\Exception $e) {

                            if ($this->errorHandler) {
                                call_user_func(
                                    $this->errorHandler,
                                    $e,
                                    $this
                                );
                            } else {
                                $this->response->setStatusCode(500);
                            }
                        }

                        // Finished
                        return $this;
                    }
                }

            } elseif (is_callable($match["target"])) {
                // Call the target directly

                try {
                    call_user_func($match["target"]);
                } catch (\Exception $e) {
                    if ($this->errorHandler) {
                        call_user_func(
                            $this->errorHandler,
                            $e,
                            $this
                        );
                    } else {
                        $this->response->setStatusCode(500);
                    }
                }

                // Finished
                return $this;
            }
        }

        // 404 if action not called

        $this->response->setStatusCode(404);

        return $this;
    }
}