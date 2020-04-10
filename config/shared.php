<?php
$dirBase = dirname(__DIR__);
$dirApp = $dirBase . DIRECTORY_SEPARATOR . 'app';
$dirDatabase = $dirApp . DIRECTORY_SEPARATOR . 'Database';
$dirMigrations = $dirDatabase . DIRECTORY_SEPARATOR . 'Migrations';
return [
    'DIR_BASE' => $dirBase,
    'DIR_APP' => $dirApp,
    'DIR_DATABASE' => $dirDatabase,
    'DIR_MIGRATIONS' => $dirMigrations,
    "app.name" => "PHP Serverless",
];