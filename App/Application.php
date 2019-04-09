<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Http\RequestInterface;
use App\Http\RouteInterface;
use App\Http\RouterInterface;
use App\logger\Logger;
use App\Views\ViewInterface;

class Application
{
    /**
     * @var RouterInterface
     */
    protected $router;

    private $logger;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->logger = new Logger();
    }

    public function handleRequest(RequestInterface $request)
    {
        try {
            $route = $this->router->resolve($request);
            $controller = $this->resolveControllerClass($route);
          //  $this->logger->log('Used controller: ' . $controller);
            $action = $this->resolveControllerAction($route, $controller);
            $this->logger->log('Action: ' . $action);
            $result = $this->runControllerAction($controller, $action, $request);
            $this->render($result);
        } catch (RouteNotFoundException $exception) {
            //TODO make 404 redirect;
            $this->render('Route not found');
        }
    }

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

    protected function resolveControllerAction(RouteInterface $route, $controller)
    {
        $action = $route->getAction();

        if (!method_exists($controller, $action)) {
            throw new \Exception('Action does not exists');
        }
        return $action;
    }

    protected function runControllerAction($controller, $action, RequestInterface $request)
    {
        $params = $request->getQueryParams();
        $postData = $request->getPostData();
        return $controller->$action($params, $postData);
    }

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
