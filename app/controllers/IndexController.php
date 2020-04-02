<?php
namespace app\controllers;

use app\core\Controllers;
use app\core\View;

class IndexController extends Controllers {

	public function indexAction()
	{
	    if(!empty($_POST))
        {
            if(!$this->model->checkBans($_SESSION['auth_session']['id'], 1))
            {
                $this->view->messages('ERROR', $this->model->error);
            }
            /*if(!$this->model->validate(['comment'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }*/
            $this->model->newPost($_SESSION['auth_session']['id'], $_POST['comment'], date('d:m:Y'));
            $this->view->location('index');
        }

        $indexPost = $this->model->getPost(); //Вывод 5 сообщений на главную
        $timeSite = $this->model->timeSite();
        $vars = [
            'comments' => $indexPost,
            'timeSite' => $timeSite,
        ];

        $this->view->renderView('Мой первый проект на собственном MVC', $vars); // Функция вывода


	}


}