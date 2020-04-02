<?php
namespace app\models;

use app\core\Models;

class TestModel extends Models
{
    public function testVk()
    {
        $token = 'https://oauth.vk.com/authorize?client_id=7302082&display=page&redirect_uri=http://obj.siliconrus.ru/vk/vk.php&scope=friends&response_type=code&v=5.103';


        $data = json_encode(file_put_contents('https://oauth.vk.com/access_token?client_id=7302082&client_secret=upRsphDlxFBW97szDhEq&redirect_uri=http://obj.siliconrus.ru/vk/vk.php&code=upRsphDlxFBW97szDhEq'), true);


        if($_GET['token'])
        {
            exit('Error token');
        }

        var_dump($data);
    }

}