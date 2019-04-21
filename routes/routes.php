<?php

use App\Controllers\Api\FormControllerApi;
use App\Controllers\FormController;
use App\Controllers\IndexController;
use App\Http\Router;

$router = new Router();

$router->add('get', '/', IndexController::class, 'index');
$router->add('get', '/forms', FormController::class, 'index');
$router->add('get', '/forms/view', FormController::class, 'view');
$router->add('post', '/forms/create', FormController::class, 'create');
$router->add('get', '/forms/update', FormController::class, 'update');
$router->add('post', '/forms/update', FormController::class, 'updatePost');
$router->add('get', '/forms/delete', FormController::class, 'delete');
/**
 * REST API Routers
 */
$router->add('get', '/api/v1/forms/', FormControllerApi::class, 'index');
$router->add('get', '/api/v1/forms/{formId}', FormControllerApi::class, 'view');
$router->add('post', '/api/v1/forms/', FormControllerApi::class, 'create');
$router->add('put', '/api/v1/forms/{formId}', FormControllerApi::class, 'update');
$router->add('delete', '/api/v1/forms/{formId}', FormControllerApi::class, 'delete');

return $router;
