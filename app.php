<?php

require_once   'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$dependencyInjectionContainer = require_once 'config/mapForDependencyContainer.php';

$responseHandler = $dependencyInjectionContainer->get(JobApplication_2019_02_24\Components\Response\JsonResponse::class);

$router = new JobApplication_2019_02_24\Components\Router\Router($dependencyInjectionContainer);


require_once 'config/routes.php';

try {
    $router->handle();
} catch (\JobApplication_2019_02_24\Components\Router\MethodNotAllowedException $e) {
    $responseHandler->fail(empty($e->getMessage())?'method not allowed' : $e->getMessage());
} catch (\JobApplication_2019_02_24\Components\Router\RouteNotFoundException $e) {
    $responseHandler->fail(empty($e->getMessage())?'route not found' : $e->getMessage());
} catch (Exception $e) {
    $responseHandler->fail(empty($e->getMessage())?'something went wrong' : $e->getMessage());
}
