<?php

namespace App\Helpers;

class App
{
    public static function env($key, $default = "")
    {
        $env = json_decode($_ENV['WHISK_INPUT'], true);
        return $env[$key] ?? $default;
    }

    public static function environment()
    {

        $env = \Sinevia\Registry::get("ENVIRONMENT");
        return $env;
    }

    public static function main()
    {
        //$uri = strtok($_SERVER["REQUEST_URI"], '?');
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        if ($method == "HEAD") {
            return ""; // No response required
        }

        $response = self::router($method, $uri);

        return $response;
    }

    public static function router($method, $uri)
    {
        $extension = pathinfo($uri, PATHINFO_EXTENSION);

        /*  1. Static files */
        $staticFileExtensions = ['css', 'js'];

        if (in_array($extension, $staticFileExtensions)) {
            $name = trim($uri, '/');
            $file = basePath('public/' . $name);
            if (file_exists($file)) {
                $response = \Sinevia\Template::fromFile($file);
                return $response;
            }
            return $name . ' DOES NOT exist on this server';
        }

        /* 2. Define routes */
        $router = new \Phroute\Phroute\RouteCollector();

        $router->group(array('prefix' => '/api'), function (\Phroute\Phroute\RouteCollector $router) {
            $router->controller('/auth', 'App\Controllers\Api\AuthController');
            $router->controller('/', 'App\Controllers\Api\HomeController');
        });

        $router->group(array('prefix' => '/user'), function (\Phroute\Phroute\RouteCollector $router) {
            $router->any('/{page}?', ['App\Controllers\User\WebController', 'anyPage']);
            $router->any('/{module}/{page}?', ['App\Controllers\User\WebController', 'anyModulePage']);
        });


        $router->group(array('prefix' => '/'), function (\Phroute\Phroute\RouteCollector $router) {
            $router->any('/{page}?', ['App\Controllers\Guest\WebController', 'anyPage']);
            $router->any('/{module}/{page}?', ['App\Controllers\Guest\WebController', 'anyModulePage']);
        });

        try {
            $dispatcher = new \Phroute\Phroute\Dispatcher($router->getData());
            $response = $dispatcher->dispatch($method, $uri);
        } catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
            $response = $e->getMessage();
        } catch (\Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
            $response = 'Method not allowed';
        } catch (\Exception $e) {
            $response = '<pre>' . $e->getMessage() . "\n" . $e->getTraceAsString() . '</pre>';
        }

        return $response;
    }

    public static function userIdFromToken($token)
    {
        $cache = \App\Plugins\CachePlugin::get($token);
        if ($cache == null) {
            return null;
        }
        return $cache['PersonId'] ?? null;
    }
}