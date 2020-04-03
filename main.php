<?php

function main()
{
    require_once __DIR__ . '/app/functions.php';
    \App\Helpers\Links::setBaseUrl(\Sinevia\Registry::get("URL_BASE", ""));
    return \App\Helpers\App::main();
}