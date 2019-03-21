<?php
require './vendor/autoload.php';

use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

$cleanSymfonyParameters = function(array $parameters) {
    unset($parameters['_controller']);
    unset($parameters['_route']);
    return $parameters;
};

try {
    $requestContext = new RequestContext('/');
    $requestContext->fromRequest(Request::createFromGlobals());

    $loader = (new PhpFileLoader(new FileLocator([__DIR__ . '/config'])));

    $router = new Router($loader, 'routes.php', [], $requestContext);

    $parameters = $router->match($requestContext->getPathInfo());

    $urlParameters = $cleanSymfonyParameters($parameters);

    $controller = $parameters['_controller'][0];
    $controllerAction = $parameters['_controller'][1];
    $response = call_user_func_array(array($controller, $controllerAction), $urlParameters);
    $response->send();

} catch(Exception $e) {
    echo $e->getMessage();
}

exit;
