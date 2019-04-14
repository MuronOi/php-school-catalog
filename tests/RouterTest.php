<?php

require __DIR__ . '/../App/Http/Router.php';
require __DIR__ . '/../App/Http/RouterInterface.php';

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
        parent::setUp();
        $this->router = new Router();
        $this->log = $this->getMockBuilder('Logger')->getMock();

        $this->log->expects($this->any())->method('log');


    }

    public function tearDown(): void
    {
        $this->router = null;
        $this->log = null;
    }

    /**
     * @dataProvider AddDataProvider
     */
    public function testAdd(string $method, string $path, string $controller, string $action, string $resClass, string $resMethod, string $resPath)
    {
        $route = $this->getMockBuilder('Route')->getMock();
        $route->expects($this->any())->method('__construct')->will($this->returnValue($controller, strtoupper($method)));
        $this->router->add($method, $path, $controller, $action);

        $this->assertEquals($resMethod, $this->router->routes[$method][$path]->getClass());
    }

    public function AddDataProvider()
    {
        return [
            ['get', '/forms', 'App\Controllers\FormController', 'index', 'App\Controllers\FormController' , 'GET', '/forms'],
            ['post', '/forms/create', 'App\Controllers\FormController', 'create', 'App\Controllers\FormController', 'POST', 'forms/create'],
        ];
    }
}