<?php
namespace app\models;

use app\core\Models;

class AccountModel extends Models
{
        /*Регистрация*/
    /* Получаем логин из БД */
    public function resLogin(string $login)
    {
        $sql = 'SELECT login FROM users WHERE login = ?';

        return $this->DB->query($sql, [$login])->fetchAssoc();

    }

    /* Получаем емейл из БД */
    public function checkEmail(string $email)
    {
        $sql = 'SELECT email FROM users WHERE email = ?';

        return $this->DB->query($sql, [$email])->fetchAssoc();

    }

    /* Получаем авы из БД */
    public function checkAvatars(int $id)
    {
        $sql = 'SELECT avatars FROM users WHERE id = ?';

        return $this->DB->query($sql, [$id])->fetchAssoc();

    }
        /* Тестирую */
    public function checkSQL(int $id, $checkMysql)
    {
        $sql = 'SELECT login, email, avatars FROM users WHERE id = ?';

        $checkSQL = $this->DB->query($sql, [$id])->fetchAssoc();

        return $checkSQL[$checkMysql];
    }
    
    /* Получаем пароль из БД */
    private function checkPwd(int $id)
    {
        $sql = 'SELECT password FROM users WHERE id = ?';

        $curr = $this->DB->query($sql, [$id])->fetchAssoc();

        $pwd_curr = $curr['password'];

        return $pwd_curr;

    }
        /* Проверка на подтверждение пароля */
    public function passwordConfirmation($password_confirmation, $password): bool
    {
        if($password_confirmation !== $password)
        {
            $this->error = 'Второй пароль  введен неверно!';
            return false;
        }
        return true;
    }

    public function createToken()
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz',
            30)), 0, 30);
    }

    public function getIP()
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function activateAccount($token): bool
    {
        $sql = 'UPDATE users SET status = ?, token = ? WHERE token = ?';
        $this->DB->query($sql, [1, '', $token]);

        return true;
    }

    public function checkToken($token, $id): bool
    {
        $sql = "SELECT {$id} FROM users WHERE token = :token";
        $checkToken = $this->DB->query($sql, [':token' => $token])->fetchAssoc();

        $checkToken = $checkToken['token'];

        if($checkToken)
        {
            return false;
        }
        return true;
    }

    public function checkTokens($token, $id)
    {
        $sql = "SELECT {$id} FROM users WHERE token = :token";
        $checkTokens = $this->DB->query($sql, [':token' => $token])->fetchAssoc();

        $checkTokens = $checkTokens['token'];

        return $checkTokens;
    }

    public function checkStatus($email): bool
    {
        $sql = 'SELECT status FROM users WHERE email = :email';
        $checkStatus = $this->DB->query($sql, [':email' => $email])->fetchAssoc();

        $status = $checkStatus['status'];

        if($status != 1)
        {
            $this->error = 'Ваш аккаунт еще не активирован';
            return false;
        }
            return true;
    }

    public function register($login, $email, $password): void
    {
        $token = $this->createToken();
        $pwd = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users SET login =:login, email = :email, password = :password, date = :date, ip = :ip,
                token = :token, status = :status';
        $this->DB->query($sql, [
            ':login' => $login,
            ':email' => $email,
            ':password' => $pwd,
            ':date' => date('Y.m.d-H:i:s'),
            ':ip' => $this->getIP(),
            ':token' => $token,
            ':status' => 0,
        ]);
        mail($email, 'Регистрация на сайте SILICONRUS.RU',
            'Добрый день! \n Спасибо за регистрацию на нашем сайте. Для активации аккаунта Вам нужно перейти
            по ссылке: '. $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] .
            '/account/confirm/' . $token);
    }

        /*БЛОК ЗАГРУЗКИ ФОТО*/
    /* Валидация фотографий */
    private function validatePhoto(): string
    {
        $extensions = ['png', 'jpeg', 'jpg'];

        if($_FILES['image']['size'] > 1024 * 3 * 1024)
        {
            $this->error = 'Размер файла не должен превышать более 3 мб.';

        }

        switch ($_FILES['image']['type'])
        {
            case 'image/png': $format = 'png';
            break;

            case 'image/jpeg': $format = 'jpeg';
            break;

            case 'image/jpg': $format = 'jpg';
            break;

            default: $format = '';
            $this->error = 'Неизвестная ошибка!';
            break;
        }

        if(!in_array($format, $extensions, true))
        {
            $this->error = 'Ваше фото не соответствует форматам: ' . implode(',', $extensions);
        }

        return $format;

    }
        /* Загрузка фотографии */
    public function loadingPhoto($avaID)
    {
        if($this->validatePhoto())
        {
            $filePath = 'public/img/users/';
            $imgName = uniqid('', true) . '.' . basename($_FILES['image']['type']);
            $uploadImg = $filePath . $imgName;

            if($avaID !== '' && $avaID != 'public/img/no-user.jpg')
            {
                unlink($avaID);
            }

            return move_uploaded_file($_FILES['image']['tmp_name'], $this->uploadImg = $uploadImg);
        }
    }
        /* Блок смены пароля */
    public function newPass($current, $password): ?bool
    {
      $verify_curr = password_verify($current, $this->checkPwd($_SESSION['auth_session']['id']));

       if($verify_curr == $this->checkPwd($_SESSION['auth_session']['id']))
       {
           $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

           $_SESSION['pwd_update'] = 'Профиль успешно обновлен';

           $this->pwd_hash = $pwd_hash;

           return true;
       } else {
           $this->error = 'Что-то пошло не так..';
           return false;
       }
    }

    public function updIP($ip, $last_activity, $id): void
    {
        $sql = 'UPDATE users SET ip = ?, last_activity = ? WHERE id = ?';

         $this->DB->query($sql, [$ip, $last_activity, $id]);
    }
        /*Авторизация, 2 версии*/

    //Работает
    /*
            public function authCheck($email, $password)
            {
                $sql = 'SELECT * FROM users WHERE email = :email';
                $hash = $this->DB->query($sql, [':email' => $email])->fetchAssoc();

                $us = $hash['password'];
                if(!$hash || !password_verify($password, $us))
                {
                    $this->error = 'Такого пользователя не найдено в базе данных!';
                    return false;
                }
                return true;
            }

            public function auth($email)
            {
                $sql = 'SELECT * FROM users WHERE email = :email';
                $data = $this->DB->query($sql, [':email'=> $email])->fetchAssoc();

                $_SESSION['auth_session'] = $data;
            }
         */
                public function auth($email, $password): bool
                {
                    $sql = 'SELECT * FROM users WHERE email = :email';
                    $hash = $this->DB->query($sql, [':email' => $email])->fetchAssoc();

                    //if($this->checkStatus($_POST['email'])) {
                    if($this->checkBans($hash['id'], 2)) {
                        if ($hash) {
                            $us = $hash['password'];
                            if (password_verify($password, $us)) {
                                $_SESSION['auth_session'] = $hash;
                                $this->updIP($this->getIP(), time(), $hash['id']);
                                return true;

                            } else {
                                $this->error = 'Некорректно введенные данные!';
                            }
                        } else {
                            $this->error = 'Нет такого аккаунта в базе!';
                        }
                    }
                    return false;
                }
        /* Перезапись сессий */
    public function updateSession($id)
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $updateSession = $this->DB->query($sql, [$id])->fetchAssoc();

        return $_SESSION['auth_session'] = $updateSession;
    }

            /* Обновление профиля */
    public function updateProfile($login, $email, $id): bool
    {
        $sql = 'UPDATE users SET login = ?, email = ? WHERE id = ?';
        $this->DB->query($sql, [$login, $email, $id]);

        $_SESSION['profile_update'] = 'Профиль успешно обновлен';
        return true;
    }

    public function updateAvatars($id): bool
    {
        $sql = 'UPDATE users SET avatars = ? WHERE id = ?';
        $this->DB->query($sql, [$this->uploadImg, $id]);

        $_SESSION['profile_update'] = 'Профиль успешно обновлен';

        return true;
    }

        /* Обновление пароля в профиле */
    public function updatesProfile($id): bool
    {
        $sql = 'UPDATE users SET password = ? WHERE id = ?';
        $this->DB->query($sql, [$this->pwd_hash, $id]);

        return true;
    }

    /* Восстановление пароля */

    public function cchEmail($email): bool
    {
        $sql = 'SELECT email FROM users WHERE email = ?';
        $cchEmail = $this->DB->query($sql, [$email])->fetchAssoc();

        $cchEmail = $cchEmail['email'];

        if($cchEmail !== $email)
        {
            $this->error = 'Данного емейла нет в БД!';
            return false;
        }
        return true;
    }

    public function reset($email): void
    {
        $resetToken = $this->createToken();

        $sql = 'UPDATE users SET status = ?, token = ? WHERE email = ?';
        $this->DB->query($sql, [0, $resetToken, $email]);

        mail($email, 'Восстановление пароля',
            'Добрый день! "\n" Вы получили это письмо, потому что мы получили запрос на смену
             пароля Вашего аккаунта. Для смены пароля перейдите по ссылке ниже:
              '. $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] .
            '/account/resetPwd/' . $resetToken);
    }

    public function resetPwd($post): void
    {

        $sql = 'UPDATE users SET password = ?, token = ?, status = ? WHERE login = ?';
        $this->DB->query($sql, [
            password_hash($post['password'], PASSWORD_DEFAULT),
            '',
            1,
            $post['login'],
        ]);
    }

    public function tToken($login, $token): bool
    {
        //$this->checkToken($this->route['token'], 'login');
        $sql = 'SELECT token FROM users WHERE login = ?';
        $tToken = $this->DB->query($sql, [$login])->fetchAssoc();

        $tToken = $tToken['token'];

        if($tToken !== $token)
        {
            $this->error = 'Токен не соответствует тому, что есть в базе!';
            return false;
        }
        return true;

    }

    /*Выход*/
    public function logout(): void
    {
        unset($_SESSION['auth_session']);
    }
}