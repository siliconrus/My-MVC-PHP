<?php
namespace app\core;

use app\config\DB;
use app\models\AdminModel;

abstract class Models
{
	protected $DB; // Экземпляр класса DB

	public function __construct() 
	{
		$this->DB = DB::getInstance();
        $this->sessionUp($_SESSION['auth_session']['id'], 'admin');
        if(!$this->checkBans($_SESSION['auth_session']['id'], 2))
        {
            unset($_SESSION['auth_session']);
        }

        //var_dump($this->dateEndBan($_POST['user_id']));
        $this->updateOnline($_SESSION['auth_session']['id']);
	}

    public function validate($input, $post)
    {
        $rules = [
            'login' => [
                'pattern' => '/^[0-9a-z]{5,15}\S$/',
                'messages' => 'Логин не должен быть менее 5 и не более 15 символов!',
            ],
            'email' => [
                'pattern' => '/^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$/',
                'messages' => 'Email не валидный!',
            ],
            'password' => [
                'pattern' => '/^[0-9a-z]{5,32}\S$/',
                'messages' => 'Пароль не должен быть менее 6 и не более 32 символов!',
            ],
            'comment' => [
                'pattern' => '/[a-zA-Z0-9_.-А-Яа-я]{2,150}/iu',
                'messages' => 'Ваш текст некорректный! Разрешено минимум 4 символа и максимум 64.',
            ],
        ];

        foreach($input as $value)
        {
            if(!isset($post[$value]) or !preg_match($rules[$value]['pattern'], $post[$value]))
            {
                $this->error = $rules[$value]['messages'];
                return false;
            }
        }
        return true;
    }

    public function dateEndBan($id)
    {

        $sql = 'SELECT * FROM ban_list WHERE user_id = ?';

        $dateEndBan = $this->DB->query($sql, [$id])->fetchAssoc();

        if($dateEndBan != '')
        {
            if ($dateEndBan['data_end'] <= date('YmdHi') && $dateEndBan['data_end'] != '-1')
            {
                $sql = 'DELETE FROM ban_list WHERE user_id = ?';

                 $this->DB->query($sql, [$dateEndBan['id']]);
            }
        }
        return $dateEndBan;
    }

    public function updateOnline($id)
    {
        $sql = "UPDATE users SET last_activity = ? WHERE id = ?";

       return $this->DB->query($sql, [time(), $id]);
    }

    public function checkBans($id, $type) //Проверяем бан-лист
    {

        $sql = 'SELECT * FROM ban_list WHERE user_id = ? AND type = ?';

        $checkBan = $this->DB->query($sql, [$id, $type])->fetchAssoc();

        if($checkBan)
        {
            $this->error = 'Вы забанены в чате!';
            return false;
        }
        return true;
    }

    public function timeSite()
    {
        $hour = (int)strftime ('%H');
        if($hour>0 and $hour<6)
        {
            $welcome = "Доброй ночи";
        }
        elseif($hour>=6 and $hour<12)
        {
            $welcome = "Доброе утро";
        }elseif($hour>=12 and $hour<18)
        {
            $welcome = "Добрый день";
        }elseif($hour>=18 and $hour<23)
        {
            $welcome =  "Доброй вечер";
        }else{
            $welcome = "Доброй ночи";
        }
        return $welcome;
    }

        /* Один запрос на получение данных для валидации из БД */
    public function checkValidates($table, $data, $checks)
    {
        $sql = "SELECT {$table} FROM users WHERE {$data} = ?";
        $checkValidates = $this->DB->query($sql, [$checks])->fetchAssoc();

        if($checkValidates)
        {
            return false;
        }
        return true;
    }
        /* Перезапись сессий */
    public function sessionUp($id, $sessionName)
    {
        $sql = 'SELECT is_admin FROM users WHERE id = ?';
        $sessionUp = $this->DB->query($sql, [$id])->fetchAssoc();

        return $_SESSION[$sessionName] = $sessionUp;
    }

}