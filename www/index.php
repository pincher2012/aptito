<?php

use Aptito\providers\DatabaseConnectionProvider;
use Aptito\providers\OrdersServiceProvider;

require_once '../vendor/autoload.php';

define('BASE_DIR', dirname(__DIR__));
define('VIEWS_DIR', BASE_DIR . '/src/views');


$app = new \Aptito\Application();

$dbParams = require_once BASE_DIR . '/db.php';
$app->register(new DatabaseConnectionProvider(), ['db.params' => $dbParams]);
$app->register(new OrdersServiceProvider());

$app->route('/', 'MainController:index')
    ->route('/app', 'ApiController:api');

$app->run();
