<?php
namespace app\models;

use app\core\Models;
use app\models\AccountModel;
use app\models\StopWordModel;

class IndexModel extends Models
{
    const MIN_LENGHT = 2;

    const MAX_LENGHT = 150;

    public $comments = 'comments';

	public function getPost() //Вывод комментариев
    {
        $sql = 'SELECT c.id, c.user_id, c.comment, c.time, u.login, u.avatars 
                    FROM comments c INNER JOIN users u ON c.user_id = u.id 
                    AND c.value = 0 ORDER BY c.id DESC LIMIT 5';

        return $this->DB->query($sql)->fetchAssocAll();

    }

    public function validateMessages($string)
    {
        $slice = explode(' ', $string);
        foreach ($slice as $key) {
            if(in_array($key, StopWordModel::rules(), true)) return false;
        }

        return true;
    }

    public function newPost( int $user_id, $comment, $date) //Добавление комментариев
    {
        //$comment = $this->filterMessages($comment);

        if(strlen($comment) >= self::MIN_LENGHT && strlen($comment) < self::MAX_LENGHT && $this->validateMessages($comment))
        {
            $sql = 'INSERT INTO comments (user_id, comment, time) VALUES (:user_id, :comment, :time)';
            $newPost = $this->DB->query($sql, [
                ':user_id' => $user_id,
                ':comment'=> $comment,
                ':time'=> $date
            ]);

            $_SESSION['comment_success'] = 'Комментарий успешно добавлен';

            return $newPost;
        }

        $_SESSION['comment_success'] = 'Ваш текст не соответсвуют нашим правилам..';

    }

 /*   public function filterMessages($comment)
    {
        $comment = strip_tags($comment);
        $comment = preg_replace("#(?:(?:https?|ftp)\:\/\/)?(?:[a-z0-9]{2,}[\.\-]?)+\.[a-z0-9]{2,}(?:\/[^[:space:]]*?)?#is", '', $comment);
        $strlen = strlen($comment);

        if(strlen($strlen) > self::MAX_LENGHT)
        {
            $_SESSION['comment_success'] = 'Максимальная длина чата не более 150 символов!';
        }
    }*/
}