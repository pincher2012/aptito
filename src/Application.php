<?php

namespace Aptito;
use Aptito\exceptions\NotFoundException;

/**
 * Класс приложения
 */
class Application
{
    /**
     * Список маршрутов
     *
     * @var array
     */
    private $routes = [];

    /**
     * Класс для работы с http запросом
     *
     * @var Request
     */
    private $request;

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->setExceptionHandler();
    }


    /**
     * Связывает маршурт и действие в контроллере
     *
     * @param string $route  маршрут
     * @param string $action контроллер и действие в формате controller:action
     *
     * @return Application
     */
    public function route($route, $action)
    {
        list($controller, $action) = explode(':', $action);
        $this->routes[$route] = ['Aptito\\controllers\\' . $controller, $action];

        return $this;
    }

    /**
     * Обрабатывает запрос к приложению
     */
    public function run()
    {
        $route = $this->request->getRoute();
        if (array_key_exists($route, $this->routes) === false) {
            throw new NotFoundException();
        }

        list($controllerClassName, $action) = $this->routes[$route];
        $controller = new $controllerClassName();
        $controller->$action($this->request);
    }

    /**
     * Устанавливает обработчик ошибок
     */
    private function setExceptionHandler()
    {
        set_exception_handler([new ExceptionHandler(), 'handle']);
    }
}