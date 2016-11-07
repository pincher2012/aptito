<?php

namespace Aptito;

/**
 * Отвечает за работу с http запросом к серверу
 */
class Request
{
    /**
     * Возвращает путь запроса
     *
     * @return string
     */
    public function getRoute()
    {
        $path = $this->get('path', '');

        return '/' . trim($path, '/');
    }

    /**
     * Возвращает get параметр запроса
     *
     * @param string $param имя параметра
     * @param mixed  $default значение по умолчанию
     *
     * @return mixed
     */
    public function get($param, $default = null)
    {
        return array_key_exists($param, $_GET) ? urldecode($_GET[$param]) : $default;
    }
}
