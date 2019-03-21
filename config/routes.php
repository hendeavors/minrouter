<?php

// config/routes.php
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\HttpFoundation\Response;

return function (RoutingConfigurator $routes) {
    $routes->add('blog_list', '/blog')->controller([BlogController::class, 'list']);
    $routes->add('blog_show', '/blog/{slug}')->controller([BlogController::class, 'show']);
    $routes->add('loaded_files', '/loaded/files')->controller([LoadedFilesController::class, 'index']);
};

class BlogController
{
    public function list()
    {
        return new Response(
            '<html><body><h1>The listing page</h1></body></html>'
        );
    }

    public function show($slug)
    {
        return new Response(
            '<html><body><h3>Showing ' . $slug . '</h3></body></html>'
        );
    }
}

class LoadedFilesController
{
    public function index()
    {
        $files = "";

        foreach(get_included_files() as $file) {
            $files .= $file . "<br>";
        }

        return new Response(
            '<html><body><h1>Included files:<br>' . $files . '</h1></body></html>'
        );
    }
}
