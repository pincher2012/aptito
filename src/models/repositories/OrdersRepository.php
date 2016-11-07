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
     * @return array
     */
    public function findAll()
    {
        $sql = '
          SELECT oi.*, p.name, (oi.price - oi.tax) AS net  
          FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          JOIN plates AS p ON p.id = oi.plate_id
          WHERE oi.date <= :now 
          ORDER BY oi.date DESC
          ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':now', gmmktime(), \PDO::PARAM_INT);
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
    public function findByDiapason($dateFrom, $dateTo)
    {
        $sql = '
          SELECT oi.*, p.name, (oi.price - oi.tax) AS net
          FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          JOIN plates AS p ON p.id = oi.plate_id
          WHERE oi.date <= :dateTo AND oi.date > :dateFrom AND oi.date <= :now 
          ORDER BY oi.date DESC
          ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':now', gmmktime(), \PDO::PARAM_INT);
        $stmt->bindParam(':dateTo', $dateTo, \PDO::PARAM_INT);
        $stmt->bindParam(':dateFrom', $dateFrom, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает заказы с заданным временем
     *
     * @param int $dateFrom дата начала
     *
     * @return array
     */
    public function findSince($dateFrom)
    {
        $sql = '
          SELECT oi.*, p.name, (oi.price - oi.tax) AS net
          FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          JOIN plates AS p ON p.id = oi.plate_id
          WHERE oi.date > :dateFrom AND oi.date <= :now 
          ORDER BY oi.date DESC
          ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':now', gmmktime(), \PDO::PARAM_INT);
        $stmt->bindParam(':dateFrom', $dateFrom, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает заказы с заданным временем
     *
     * @param int $dateTo дата окончания
     *
     * @return array
     */
    public function findUntil($dateTo)
    {
        $sql = '
          SELECT oi.*, p.name, (oi.price - oi.tax) AS net
          FROM orders AS o
          JOIN order_items AS oi ON o.id = oi.order_id
          JOIN plates AS p ON p.id = oi.plate_id
          WHERE oi.date <= :dateTo AND oi.date <= :now
          ORDER BY oi.date DESC
          ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':now', gmmktime(), \PDO::PARAM_INT);
        $stmt->bindParam(':dateTo', $dateTo, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
