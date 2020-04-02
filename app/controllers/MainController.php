<?php
namespace app\controllers;

use app\core\Controllers;
use app\core\View;

class MainController extends Controllers
{
    public function deleteAction()
    {
        $this->model->deleteMyPost($this->route['id']);
        $this->view->redirect('index');

        //$this->view->renderView('Мой первый проект на собственном MVC');

    }
}