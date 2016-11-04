<?php

namespace Aptito\models\repositories;

/**
 * Репозиторий заказов
 */
class OrdersRepository
{
    /**
     * Соединение с бд
     *
     * @var \PDO
     */
    private $connection;

    /**
     * OrdersRepository constructor.
     *
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Возвращает последние заказы
     *
     * @param int $limit количество возвращаемых записей
     *
     * @return array
     */
    public function findLastOrders($limit = 20)
    {
        $sql = '
          SELECT oi.*, o.date FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          WHERE o.date <= :now 
          ORDER BY o.date DESC
          LIMIT :limit
          ';

        $now = time();
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':now', $now, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает заказы с заданным временем
     *
     * @param int $dateFrom дата начала
     * @param int $dateTo   дата окончания
     *
     * @return array
     */
    public function findOrdersByDiapason($dateFrom, $dateTo)
    {
        $sql = '
          SELECT oi.*, o.date FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          WHERE o.date <= :dateTo and o.date > :dateFrom 
          ORDER BY o.date DESC
          ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':dateTo', $dateTo, \PDO::PARAM_INT);
        $stmt->bindParam(':dateFrom', $dateFrom, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}