<?php
namespace app\models;

use app\core\Models;

class AdminModel extends Models
{
    public $page = 1;
    public $perPage = 10;
    public $error;
    public $dateEnd;

    public function allComments()
    {
        $sql = 'SELECT c.id, c.user_id, c.comment, c.value, c.time, u.login, u.avatars 
                    FROM comments c LEFT JOIN users u ON c.user_id = u.id 
                     ORDER BY c.id DESC LIMIT 10';

       return $this->DB->query($sql)->fetchAssocAll();

    }

    public function isAdmin($id)
    {
        $sql = 'SELECT is_admin FROM users WHERE id = :id';

        $isAdmin = $this->DB->query($sql, [':id' => $id])->fetchAssoc();

        return $_SESSION['admin'] = $isAdmin;
    }

    public function checkBan()
    {
        $sql = "SELECT b.id, b.user_id, b.cause, b.type, b.data_end, u.login, u.avatars 
                FROM ban_list b LEFT JOIN users u
                ON b.user_id = u.id ORDER BY b.id DESC";

        return $this->DB->query($sql)->fetchAssocAll();

    }

    public function onlineAdminPanel()
    {
        $sql = "SELECT id, avatars, login, ip, last_activity FROM users WHERE last_activity > '".(time() - 61)."'";

        return $this->DB->query($sql)->fetchAssocAll();
    }

    public function adminValidate($post): bool
    {
        if(trim($post['userID']) == '')
        {
            $this->error = 'Это обязательное поле!';
            return false;
        }
        elseif(trim($post['reason']) == '')
        {
            $this->error = 'Вы не можете заблокировать не указав причину!';
            return false;
        }
        elseif($post['type'] == '')
        {
            $this->error = 'Вы не можете заблокировать пользователя не указав тип!';
            return false;
        }
        elseif($post['forever'] != on) // Выставляем время, если это не бесконечность
        {
            //Проверяем правильность введенной даты
            if($post['timeto1'] < 0 || $post['timeto1'] > 23 || $post['timeto2'] < 0 || $post['timeto2'] > 59)
            {
                $this->error = 'Введен неверный формат даты.';
            }

            $date = explode('-', $post['dateto']);
            $this->dateEnd = $date['2']. $date['1'].$date['0'].$post['timeto1'].$post['timeto2'];


        } else $this->dateEnd = '-1'; //Вечный бан

        return true;
    }

    public function newBan(int $userID, $userIP, string $cause, int $type)
    {
        $sql = 'INSERT INTO ban_list (user_id, user_ip, cause, type, data_end) VALUES (:user_id, :user_ip, :cause,
                            :type, :data_end)';

        return $this->DB->query($sql, [
           ':user_id' => $userID,
           ':user_ip' => $userIP,
           ':cause' => $cause,
           ':type' => $type,
           ':data_end' => $this->dateEnd,
        ]);
    }

    public function siteBan(int $user_id, $type): void
    {
        $sql = 'INSERT INTO ban_list SET user_id = ?, cause = ?, type = ?';

        $this->DB->query($sql, [$user_id, 'Вас забанил анти-чит', $type]);
    }

    public function checkTakeBan($id, $type): bool
    {
        $sql = 'SELECT * FROM ban_list WHERE user_id = ? AND type = ?';

        $checkTakeBan = $this->DB->query($sql, [$id, $type])->fetchAssoc();

        if($checkTakeBan > 0)
        {
            $this->error = 'Данный пользователь уже заблокирован.';

            return false;
        }

        return true;
    }

    public function allUsers()
    {

        $sql = 'SELECT id AS totalPage FROM users ORDER BY id DESC LIMIT 10';

        $totalPage = $this->DB->query($sql)->fetchAssoc();
        $totalPage = $totalPage['totalPage'];

        $totalPages = ceil($totalPage / $this->perPage);

        if($totalPages <= 0 || $this->page > $totalPages)
        {
            $this->page = 1;
        }

        $offset = ($this->perPage * $this->page) - $this->perPage;

        $allUsers = $this->DB->query("SELECT * FROM users ORDER BY id ASC")->fetchAssocAll();

        $pageExists = true;

        if($allUsers <=0 )
        {
            echo 'Статей не обнаружено!';
            $pageExists = false;
        }

        return $allUsers;

    }

    public function unbanUser($id)
    {
        $sql = 'DELETE FROM ban_list WHERE id = :id';

       return $this->DB->query($sql, [':id' => $id]);
    }

    public function deleteComment($id)
    {
        $sql = 'DELETE FROM comments WHERE id = ?';

        return $this->DB->query($sql, [$id]);
    }

    public function allowNoComment($value, $id)
    {
        $sql = 'UPDATE comments SET value = ? WHERE id = ?';

        return $this->DB->query($sql, [$value, $id]);
    }

}