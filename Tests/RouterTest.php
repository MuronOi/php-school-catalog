<?php

require __DIR__ . '/../App/Http/RouterInterface.php';
require __DIR__ . '/../App/Http/Router.php';
require __DIR__ . '/../App/logger/LoggerInterface.php';
require __DIR__ . '/../App/logger/Logger.php';
require __DIR__ . '/../App/Http/RouteInterface.php';
require __DIR__ . '/../App/Http/Route.php';

use App\Http\Router;
use App\Http\RouterInterface;

class RouterTest extends \PHPUnit\Framework\TestCase
{
    private $router;
    private $log;

    /**
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        $this->log = $this->createMock(\App\logger\Logger::class);
        $this->log->method('log')->with('');

        $this->router = new Router();
    }

    public function tearDown(): void
    {
        $this->router = null;
        $this->log = null;
    }

//    /**
//     * @dataProvider AddDataProvider
//     */
//    public function testAdd(string $method, string $path, string $controller, string $action, string $resClass, string $resMethod, string $resPath)
//    {
//        $route = $this->createMock(\App\Http\Route::class);
//       // $route->method('__construct')->with($controller, strtoupper($method));
//
//        $this->router->add($method, $path, $controller, $action);
//
//        $this->assertEquals($resMethod, $this->router->routes[$method][$path]->getClass());
//    }
    public function testResolve()
    {

    }

    public function AddDataProvider()
    {
        return [
            ['get', '/forms', 'App\Controllers\FormController', 'index', 'App\Controllers\FormController' , 'GET', '/forms'],
            ['post', '/forms/create', 'App\Controllers\FormController', 'create', 'App\Controllers\FormController', 'POST', 'forms/create'],
        ];
    }
}