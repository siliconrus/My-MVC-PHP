<?php
namespace app\controllers;

use app\core\Controllers;

class TestController extends Controllers
{
    public function homeAction()
    {
        $this->view->renderView('Здесь тестируем всякие штучки'); // Функция вывода
    }
    public function vkAction()
    {
        $this->model->testVk();
        $this->view->renderView('Авторизация через вк'); // Функция вывода
    }
}