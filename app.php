<?php

require (__DIR__ . '/vendor/autoload.php');

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Pixel\Controller\ImageHandlerController;
use Symfony\Component\DependencyInjection\Reference;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Response;

$container = new ContainerBuilder();

$container
    ->register('current_request')
    ->setFactory([Request::class, 'createFromGlobals']);

$container
    ->register('image_handler_controller', ImageHandlerController::class)
    ->setArguments([
        new Reference('current_request')
    ]);

$dispatcher = FastRoute\simpleDispatcher(
    function(FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/image.png', 'image_handler_controller');
    }
);

$request = $container->get('current_request');

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    rawurldecode(parse_url($request->getRequestUri(), PHP_URL_PATH))
);

if (reset($routeInfo) !== Dispatcher::FOUND) {
    Response::create('Not found', 404)->send();
}

$handler = $routeInfo[1];
$parameters = $routeInfo[2];

if (!$container->has($handler)) {
    Response::create('Not found', 404)->send();
}

$response = $container->get($handler)->handle();

$response->send();

