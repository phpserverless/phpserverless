<?php

namespace Tests;

\Sinevia\Registry::set("DB_TYPE", "TESTING");

abstract class BaseTest extends \PHPUnit\Framework\TestCase
{

    function setUp(): void
    {
        parent::setUp();
        \Sinevia\Registry::set("DB_TYPE", "sqlite");
        \Sinevia\Registry::set("DB_HOST", ":memory:");
        \Sinevia\Registry::set("DB_NAME", "phpserverless");
        \Sinevia\Registry::set("DB_USER", "phpserverless");
        \Sinevia\Registry::set("DB_PASS", "");
        \Sinevia\Registry::set("DIR_MIGRATIONS_DIR", \dirname(__DIR__) . '/app/database/migrations');

        //\Sinevia\Migrate::setDirectoryMigration(\Sinevia\Registry::get('DIR_MIGRATIONS_DIR'));
        //\Sinevia\Migrate::setDatabase(db());
        //\Sinevia\Migrate::$verbose = false;
        //\Sinevia\Migrate::up();
    }

    protected function get($path, $data = [])
    {
        $_REQUEST = $data;
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = $path;
        return main();
    }

    protected function post($path, $data = [])
    {
        $_REQUEST = $data;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = $path;
        return main();
    }
}