<?php
namespace app\controllers;

use app\core\Controllers;
use app\core\View;

class AccountController extends Controllers
{
    /*Регистрация*/
    public function registerAction()
    {
        if (!empty($_POST))
        {
            if(!$this->model->validate(['login', 'email', 'password'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }
            elseif (!$this->model->checkValidates('login', 'login', $_POST['login']))
            {
                $this->view->messages('error', 'Такой логин уже существует в базе данных!');
            }
            elseif (!$this->model->checkValidates('email', 'email', $_POST['email']))
            {
                $this->view->messages('error', 'Такой email уже существует в базе данных!');
            }
            elseif(!$this->model->passwordConfirmation($_POST['password_confirmation'], $_POST['password']))
            {
                $this->view->messages('error', $this->model->error);
            }
            $this->model->register($_POST['login'], $_POST['email'], $_POST['password']);
            $this->view->location('index');
        }

        $this->view->renderView('Регистрация'); // Функция вывода
    }
        /* Активация аккаунта */

    public function confirmAction()
    {
        if(!$this->model->checkToken($this->route['token'], 'id'))
        {
            $this->view->redirect('account/auth');
        }

        $this->model->activateAccount($this->route['token']);
        $this->view->renderView('Активация аккаунта');
    }
    public function resetAction()
    {
        if(!empty($_POST))
        {
            if(!$this->model->validate(['email'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }
            if(!$this->model->cchEmail($_POST['email']))
            {
                $this->view->messages('ERROR', $this->model->error);
            }
            $this->model->reset($_POST['email']);
            $this->view->location('index');
        }
        $this->view->renderView('Восстановление пароля');
    }

    public function resetPwdAction()
    {
        if($this->route['token'] == $this->model->checkTokens($this->route['token'], 'token')) {

            if (!empty($_POST))
            {
                if (!$this->model->resLogin($_POST['login'])) {
                    $this->view->messages('error', 'Такой логин уже существует в базе данных!');
                }
                if (!$this->model->tToken($_POST['login'], $this->route['token'])) {
                    $this->view->messages('Error', $this->model->error);
                }
                if (!$this->model->passwordConfirmation($_POST['password_confirmation'], $_POST['password'])) {
                    $this->view->messages('error', $this->model->error);
                }
                $this->model->resetPwd($_POST);
                $this->view->location('account/auth');

            }
        } else  View::errorType(500);

        $this->view->renderView('Сброс пароля');
    }

        /*Авторизация*/
    public function authAction()
    {
            //Реализация авторизации
        if(!empty($_POST))
        {
//            if(!$this->model->authCheck($_POST['email'], $_POST['password']))
//            {
//                $this->view->messages('ERROR', $this->model->error);
//            }
            if(!$this->model->validate(['email', 'password'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }
            if(!$this->model->checkStatus($_POST['email']))
            {
                $this->view->messages('error', $this->model->error);
            }
            if(!$this->model->auth($_POST['email'], $_POST['password']))
            {
                $this->view->messages('ERROR', $this->model->error);

            } else $this->view->location('index');
        }
        $this->view->renderView('Авторизация'); // Функция вывода
    }

        /* PROFILE */
    public function profileAction()
    {
        if(!empty($_POST))
        {
            if(!$this->model->validate(['login', 'email'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }
            $login = $this->model->resLogin($_POST['login']);

            if($login && ($_POST['login'] !== $_SESSION['auth_session']['login']))
            {
                $this->view->messages('ERROR', 'Такой логин уже существует в базе данных!');
            }
            $email = $this->model->checkEmail($_POST['email']);

            if($email && ($_POST['email'] !== $_SESSION['auth_session']['email']))
            {
                $this->view->messages('ERROR', 'Такой емейл уже существует в базе данных!');
            }
            $img = $this->model->checkAvatars($_SESSION['auth_session']['avatars']);

            if(($_FILES['image']['name'] == '') && $img !== 'public/img/no-user.jpg')
            {
                $this->model->updateProfile($_POST['login'], $_POST['email'], $_SESSION['auth_session']['id']);
                $_SESSION['profile_update'] = 'Профиль успешно обновлен';
                $this->view->location('account/profile');
            }
            else
            {
                $this->model->loadingPhoto($_SESSION['auth_session']['avatars']);
                $this->model->updateAvatars($_SESSION['auth_session']['id']);

            }

            //$this->model->updateProfile($_POST['login'], $_POST['email'], $_SESSION['auth_session']['id']);
            $this->view->location('account/profile');
        }
        $this->model->updateSession($_SESSION['auth_session']['id']);
        $this->view->renderView('Профиль');
    }

    public function profilesAction()
    {
        if (!empty($_POST))
        {
            if(!$this->model->validate(['password'], $_POST))
            {
                $this->view->messages('error', $this->model->error);
            }
            if(!$this->model->newPass($_POST['current'], $_POST['password']))
            {
                $this->view->messages('ERROR', 'Текущий пароль не правильный!');
            }
            if(!$this->model->passwordConfirmation($_POST['password_confirmation'], $_POST['password']))
            {
                $this->view->messages('error', $this->model->error);
            }

           if(!$this->model->updatesProfile($_SESSION['auth_session']['id']))
           {
               $this->view->messages('error', 'Что-то пошло не так..');

           } else
           {
               $this->model->logout();

               $this->view->location('index');

           }
        }
        $this->model->updateSession($_SESSION['auth_session']['id']);
        $this->view->renderView('Профиль');
    }

    /*Выход*/
    public function logoutAction()
    {
        $this->model->logout();
        $this->view->redirect('index');
    }
}

