<?php

require_once '../vendor/autoload.php';

define('BASE_DIR', dirname(__DIR__));
define('VIEWS_DIR', BASE_DIR . '/src/views');

$app = new \Aptito\Application();

$app->route('/', 'MainController:index')
    ->route('/app', 'ApiController:api');

$app->run();