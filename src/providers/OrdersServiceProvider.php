<?php

namespace Aptito\providers;

use Aptito\models\DateTimeValidator;
use Aptito\models\repositories\OrdersRepository;
use Aptito\models\services\OrdersService;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class OrdersServiceProvider
 */
class OrdersServiceProvider implements ServiceProviderInterface
{
    /**
     * Регистрация сервиса заказов
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['orders'] = function ($app) {
            $app['orders.repository'] = new OrdersRepository($app['connection']);
            $app['validator.date'] = new DateTimeValidator();
            $service = new OrdersService(
                $app['orders.repository'],
                $app['validator.date']
            );

            return $service;
        };
    }
}
