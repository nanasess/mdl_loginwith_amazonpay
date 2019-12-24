<?php
/** このファイルは html/router.php にコピーして使用してください */
require_once __DIR__.'/require.php';

$routes = require_once __DIR__.'/../data/vendor/nanasess/mdl_sso/routes.php';

function simpleDispatcher(callable $routeDefinitionCallback, array $options = [])
{
    $options += [
        'routeParser' => 'FastRoute\\RouteParser\\Std',
        'dataGenerator' => 'FastRoute\\DataGenerator\\GroupCountBased',
        'dispatcher' => 'FastRoute\\Dispatcher\\GroupCountBased',
        'routeCollector' => 'FastRoute\\RouteCollector',
    ];

    /** @var FastRoute\RouteCollector $routeCollector */
    $routeCollector = new $options['routeCollector'](
        new $options['routeParser'], new $options['dataGenerator']
    );

    $routeCollector->addRoute(['GET', 'POST'], '/shopping/amazonpay', function (array $vars) {
        $objPage = new LC_Page_Shopping_AmazonPay();
        $objPage->init();
        $objPage->process();
    });
    $routeDefinitionCallback($routeCollector);

    return new $options['dispatcher']($routeCollector->getData());
}
$dispatcher = simpleDispatcher($routes);
// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

list($status, $handler, $vars) = $dispatcher->dispatch($httpMethod, $uri);

switch ($status) {
    case FastRoute\Dispatcher::NOT_FOUND:
        if (php_sapi_name() === 'cli-server') {
            return false;
        } else {
            header('HTTP', true, 404);
        }
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header('HTTP', true, 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        echo $handler($vars);
    default:
}
