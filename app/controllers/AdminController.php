<?php
namespace app\controllers;

use app\core\Controllers;
use app\core\View;

class AdminController extends Controllers
{
    public function indexAction()
    {
        $allComments = $this->model->allComments();


        $this->model->isAdmin($_SESSION['auth_session']['id']);

        $vars = [
            'allComments'     => $allComments,
        ];

        $this->view->renderView('Админ-панель', $vars); // Функция вывода
    }

    public function onlineAction()
    {
        $onlineAdminPanel = $this->model->onlineAdminPanel();
        $vars = [
          'onlineAdminPanel' => $onlineAdminPanel,
            ];

        $this->view->renderView('Онлайн | Админ-панель', $vars); // Функция вывода
    }

    public function banAction()
    {
        if(!empty($_POST))
        {
            if(!$this->model->checkTakeBan($_POST['userID'], '1'))
            {
                $this->view->messages('error', $this->model->error);
            }
            if(!$this->model->adminValidate($_POST))
            {
                $this->view->messages('error', $this->model->error);
            }

            $this->model->newBan($_POST['userID'], $_POST['userIP'], $_POST['reason'], $_POST['type']);
            $this->view->location('admin/ban');
        }

        $checkBan = $this->model->checkBan();

        $vars = [
            'checkBan' => $checkBan,
        ];
        $this->view->renderView('Бан-лист | Админ-панель', $vars); // Функция вывода
    }

    public function usersAction()
    {
        $allUsers = $this->model->allUsers();

        $vars = [
            'allUsers' => $allUsers,
        ];

        $this->view->renderView('Все пользователи | Админ-панель', $vars); // Функция вывода
    }

    public function banUsersAction()
    {
        if(!$this->model->checkTakeBan($this->route['id'], $this->route['type']))
        {
            $this->view->messages('error', 'Hello, world');
        }
        $this->model->siteBan($this->route['id'], $this->route['type']);
        $this->view->redirect('admin/users');
    }

    public function deleteBanAction()
    {
        $this->model->unbanUser($this->route['id']);
        $this->view->redirect('admin/ban');

    }

    public function deleteCommentAction()
    {
        $this->model->deleteComment($this->route['id']);
        $this->view->redirect('admin');

    }

    public function allowCommentsAction()
    {
      $this->model->allowNoComment($this->route['value'], $this->route['id']);

        $this->view->redirect('admin');

    }
}