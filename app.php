<?php

require (__DIR__ . '/app/config.php');

use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Response;
use Pixel\ContainerBuilder;

$container = (new ContainerBuilder($parameters))->compile();

$dispatcher = FastRoute\simpleDispatcher(
    function(FastRoute\RouteCollector $routeCollector) {
        $routeCollector->addRoute('GET', '/image.png', 'image_controller');
    }
);

$request = $container->get('current_request');

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    parse_url($request->getRequestUri(), PHP_URL_PATH)
);

if (reset($routeInfo) !== Dispatcher::FOUND) {
    return Response::create('Not found', 404)->send();
}

$controller = $routeInfo[1];
$parameters = $routeInfo[2];

if (!$container->has($controller)) {
    return Response::create('Not found', 404)->send();
}

return $container->get($controller)
    ->handle($parameters)
    ->send()
;
