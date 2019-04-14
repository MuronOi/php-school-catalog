<?php

require __DIR__ . '/../App/Http/RouteInterface.php';
require __DIR__ . '/../App/Http/Route.php';
require __DIR__ . '/../App/logger/LoggerInterface.php';
require __DIR__ . '/../App/logger/Logger.php';


use App\Http\Route;

class RouteTest extends PHPUnit\Framework\TestCase
{
    private $route;
    private $log;


    public function setUp(): void
    {
        $this->log = $this->createMock(\App\logger\Logger::class);
        $this->log->method('log')->with('');
    }

    public function tearDown(): void
    {
        $this->route = null;
    }

    /**
     * @dataProvider routeDataProvider
     */
    public function testGetClass($class, $action)
    {
        $this->route = new Route($class, $action);
        $this->assertEquals($class, $this->route->getClass());
    }

    /**
     * @dataProvider routeDataProvider
     */
    public function testGetAction($class, $action)
    {
        $this->route = new Route($class, $action);
        $this->assertEquals($action, $this->route->getAction());
    }

    public function routeDataProvider()
    {
        return [
            ['App\Controllers\IndexController', 'index'],
            ['App\Controllers\FormController',  'view'],
            ['App\Controllers\FormController', 'create'],
            ['App\Controllers\FormController', 'update'],
            ['App\Controllers\FormController', 'updatePost'],
            ['App\Controllers\FormController', 'delete'],
        ];
    }
}