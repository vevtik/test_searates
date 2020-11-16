<?php

use app\lib\Router;

require_once __DIR__ . '/../app/boot.php';

$router = new Router();
echo $router->run();
