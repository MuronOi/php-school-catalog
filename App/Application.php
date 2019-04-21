<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Http\RequestInterface;
use App\Http\RouteInterface;
use App\Http\RouterInterface;
use App\logger\Logger;
use App\Views\ViewInterface;

/**
 * Class Application
 * @package App
 */
class Application
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * Application constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->logger = new Logger();
    }

    /**
     * @param RequestInterface $request
     * @throws \Exception
     */
    public function handleRequest(RequestInterface $request)
    {
        try {
            $route = $this->router->resolve($request);

            $controller = $this->resolveControllerClass($route);

            $action = $this->resolveControllerAction($route, $controller);
            $bindngs = $route->resolveParams($request);

            $this->logger->log('Action: ' . $action);

            $result = $this->runControllerAction($controller, $action, $request, $bindngs);
            $this->render($result);
        } catch (RouteNotFoundException $exception) {
            //TODO make 404 redirect;
            $this->render('Route not found');
        }
    }

    /**
     * @param RouteInterface $route
     * @return mixed
     */
    protected function resolveControllerClass(RouteInterface $route)
    {
        $class = $route->getClass();

        try {
            if (!class_exists($class)) {
                throw new \Exception('Controller class does not exists');
            }
        } catch (\Exception $e) {
            $this->logger->log($e ->getMessage() . 'Controller: ' . $class, 'error');
        }

        return new $class;
    }

    /**
     * @param RouteInterface $route
     * @param $controller
     * @return string
     * @throws \Exception
     */
    protected function resolveControllerAction(RouteInterface $route, $controller)
    {
        $action = $route->getAction();
      //  $bindings = $route->resolveParams();

        if (!method_exists($controller, $action)) {
            throw new \Exception('Action does not exists');
        }


        return $action;
    }

    /**
     * @param $controller
     * @param $action
     * @param RequestInterface $request
     * @param $bindings
     * @return mixed
     */
    protected function runControllerAction($controller, $action, RequestInterface $request, $bindings)
    {
        $params = $request->getQueryParams();
        $postData = $request->getPostData();
        $putData = $request->getPutData();
        return $controller->$action($params, $postData, $putData, $bindings);
    }

    /**
     * @param $result
     */
    protected function render($result)
    {
        try {
            if ($result instanceof ViewInterface) {
                $result->render();
            } elseif (is_string($result)) {
                echo $result;
            } else {
                throw new \Exception('Unsupported type');
            }
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage() . 'Class:' . get_class($result), 'error');
        }

    }
}
