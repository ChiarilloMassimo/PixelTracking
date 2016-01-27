<?php

require (__DIR__ . '/app/config.php');

use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Response;
use Pixel\ContainerBuilder;
use Pixel\Notifier\Notifier;

$container = (new ContainerBuilder($config))->compile();

$notifiers = array_keys($container->findTaggedServiceIds('notifier'));
$notifier = new Notifier(
    array_map(
        function($id) use ($container) {
            return $container->get($id);
        },
        $notifiers
    )
);

$dispatcher = FastRoute\simpleDispatcher(
    function(FastRoute\RouteCollector $routeCollector) {
        $routeCollector->addRoute('GET', '/', 'image_controller');
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
    ->handle($parameters, $notifier)
    ->send()
;
