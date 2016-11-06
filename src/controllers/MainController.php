<?php

namespace Aptito\controllers;

use Aptito\Application;
use Aptito\models\services\OrdersService;
use Aptito\Request;

/**
 * Основной контроллер приложения, обрабатывает главную страницу
 */
class MainController
{
    /**
     * Обрабатывает главную страницу
     *
     * @param Application $app
     * @param Request     $request
     */
    public function index(Application $app, Request $request)
    {
        /** @var OrdersService $ordersService */
        $ordersService = $app['orders'];
        $orders = $ordersService->getAll();
        $total = $ordersService->calculateTotal($orders);

        require_once VIEWS_DIR . '/index.php';
    }
}
