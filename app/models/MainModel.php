<?php
namespace app\models;

use app\core\Models;

class MainModel extends Models
{
    public function deleteMyPost(int $id)
    {
        $sql = 'DELETE FROM comments WHERE id = ?';

        return $this->DB->query($sql, [$id]);
    }
}