<?php

namespace Aptito\providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class DatabaseConnectionProvider
 */
class DatabaseConnectionProvider implements ServiceProviderInterface
{
    /**
     * Инициализация соединения с БД
     *
     * @param Container $pimple DI контейнер
     */
    public function register(Container $pimple)
    {
        $pimple['connection'] = function ($app) {
            $dbParams = $app['db.params'];
            $dsn = sprintf(
                '%s:host=%s;dbname=%s',
                $dbParams['driver'],
                $dbParams['host'],
                $dbParams['database']
            );

            $connection = new \PDO($dsn, $dbParams['user'], $dbParams['password']);

            return $connection;
        };
    }
}