<?php

namespace Aptito\models;

/**
 * Класс для валидации даты
 */
class DateTimeValidator
{
    /**
     * Валидирует дату
     *
     * @param string $date дата
     *
     * @return bool
     */
    public function validate($date)
    {
        if ($date === null) {
            return true;
        }

        $filterResult = filter_var($date, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

        return $filterResult !== false;
    }
}
