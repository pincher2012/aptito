<?php

namespace Aptito;

use Aptito\exceptions\NotFoundException;

/**
 * Обработчик ошибок микрофреймворка
 */
class ExceptionHandler
{
    /**
     * Карта обработчиков ошибок
     *
     * @var array
     */
    private $handlers = [
        'Aptito\exceptions\NotFoundException' => 'handle404'
    ];

    /**
     * Функция обработки ошибок
     *
     * @param \Exception $exception исключение
     *
     * @throws \Exception
     */
    public function handle(\Exception $exception)
    {
        $type = get_class($exception);
        if (array_key_exists($type, $this->handlers)) {
            $handler = $this->handlers[$type];
            $this->$handler($exception);
        } else {
            throw $exception;
        }
    }

    /**
     * Обрабатывает исключение NotFoundException
     *
     * @param NotFoundException $exception исключение
     */
    private function handle404(NotFoundException $exception)
    {
        http_response_code(404);
        require_once VIEWS_DIR . '/404.php';

        exit;
    }
}
