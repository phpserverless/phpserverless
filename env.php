<?php

$environment = "local"; // !!! Do not change will be modified automatically during deployment

\Sinevia\Registry::setIfNotExists("ENVIRONMENT", $environment);
\Sinevia\Serverless::loadFileToRegistry(__DIR__ . "/config/shared.php");
\Sinevia\Serverless::loadFileToRegistry(__DIR__ . "/config/$environment.php");