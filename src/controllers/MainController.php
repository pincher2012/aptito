<?php

namespace Aptito\controllers;

use Aptito\Request;

/**
 * Основной контроллер приложения, обрабатывает главную страницу
 */
class MainController
{
    /**
     * Обрабатывает главную страницу
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        require_once VIEWS_DIR . '/index.php';
    }
}