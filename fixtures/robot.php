<?php

use app\lib\RateManager;

require_once __DIR__ . '/../app/boot.php';

$routes = [
    'CNSHA-ITNAP',
    'UAODS-CNSHA'
];
array_walk($routes, 'parseRoute');

function parseRoute($route): void
{
    $manager = new RateManager();
    list($portFrom, $portTo) = $manager->getRoutePorts($route);
    $manager->parseRates($portFrom, $portTo);
}
