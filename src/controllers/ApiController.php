<?php

namespace Aptito\controllers;

use Aptito\Application;
use Aptito\models\services\OrdersService;
use Aptito\Request;

/**
 * Контроллер обрабатывающий запросы к api
 */
class ApiController
{
    /**
     * Обработка запросов к api
     *
     * @param Application $app
     * @param Request     $request
     */
    public function api(Application $app, Request $request)
    {
        /** @var OrdersService $ordersService */
        $ordersService = $app['orders'];
        $orders = $ordersService->getByDate(
            $request->get('dateFrom'),
            $request->get('dateTo')
        );

        header('Content-Type: application/json');
        echo json_encode($orders);
    }
}
