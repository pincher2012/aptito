<?php

namespace Aptito\controllers;

use Aptito\Application;
use Aptito\exceptions\ValidationException;
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
        header('Content-Type: application/json');

        try {
            $orders = $ordersService->getByDate(
                $request->get('dateFrom'),
                $request->get('dateTo')
            );

            $result = [
                'status'  => 'success',
                'data'    => [
                    'orders' => $orders,
                    'total'  => $ordersService->calculateTotal($orders)
                ],
                'message' => null
            ];
        } catch (ValidationException $e) {
            $result = [
                'status'  => 'error',
                'data'    => null,
                'message' => $e->getMessage()
            ];
        }

        echo json_encode($result);
    }
}
