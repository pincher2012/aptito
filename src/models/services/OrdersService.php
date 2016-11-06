<?php

namespace Aptito\models\services;

use Aptito\exceptions\ValidationException;
use Aptito\models\DateTimeValidator;
use Aptito\models\repositories\OrdersRepository;

/**
 * Сервис заказов
 */
class OrdersService
{
    /**
     * Репозиторий заказов
     *
     * @var OrdersRepository
     */
    private $repository;

    /**
     * Валидатор даты
     *
     * @var DateTimeValidator
     */
    private $dateValidator;

    /**
     * Конструктор
     *
     * @param OrdersRepository  $repository репозиторий
     * @param DateTimeValidator $dateValidator
     */
    public function __construct(OrdersRepository $repository, DateTimeValidator $dateValidator)
    {
        $this->repository = $repository;
        $this->dateValidator = $dateValidator;
    }

    /**
     * Возвращает все заказы
     *
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Возвращает заказы в заданном диапазоне
     *
     * @param int|null $dateFrom дата начала
     * @param int|null $dateTo   дата окончания
     *
     * @return array
     */
    public function getByDate($dateFrom, $dateTo)
    {
        $this->validateDates([$dateFrom, $dateTo]);
        if ($dateFrom !== null && $dateTo !== null) {
            return $this->repository->findByDiapason($dateFrom, $dateTo);
        }

        if ($dateTo === null) {
            return $this->repository->findSince($dateFrom);
        }

        if ($dateFrom === null) {
            return $this->repository->findUntil($dateTo);
        }

        return $this->repository->findAll();
    }

    /**
     * Вычисляет и возвращает суммарные показатели
     *
     * @param array $orders
     *
     * @return array
     */
    public function calculateTotal(array $orders)
    {
        $result = [
            'count' => count($orders),
            'qty'   => array_sum(array_column($orders, 'qty')),
            'price' => array_sum(array_column($orders, 'price')),
            'tax'   => array_sum(array_column($orders, 'tax')),
            'net'   => array_sum(array_column($orders, 'net')),
        ];

        return $result;
    }

    /**
     * Валидирует массив дат в формате timestamp
     *
     * @param array $array массив дат
     *
     * @throws ValidationException
     */
    private function validateDates(array $array)
    {
        $result = array_filter(array_map([$this->dateValidator, 'validate'], $array));
        if (count($result) === 0) {
            throw new ValidationException('Не верный формат даты');
        }
    }
}
