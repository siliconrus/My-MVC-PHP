<?php
namespace app\core;

class View
{
	public $route;
	public $path;
	public $layout = 'index';

	public function __construct($route) 
	{
		$this->route = $route;
		$this->path = $route['controllers'] .'/'. $route['action'];
	}

	public function renderView($title, $vars = []) 
	{
	    extract($vars);
		if(file_exists('app/view/'. $this->path . '.php'))
		{
			ob_start();
			require 'app/view/'. $this->path . '.php';
            $content = ob_get_clean();
			require 'app/view/layouts/'. $this->layout . '.php';

		} else echo 'Вид не найден!';
	}

	public static function errorType($type)
	{
		http_response_code($type);
		$path = 'app/view/errors/' .$type .'.php';

		if(file_exists($path))
		{
			require $path;
		}
		exit;
	}

	public function redirect($header)
    {
        header('Location: /'. $header);
    }

	public function messages($status, $message)
    {
        exit(json_encode(['status'=> $status, 'message'=> $message]));
    }

    public function sessionMess($mess)
    {
        echo $mess;
    }

    public function location($url)
    {
        exit(json_encode(['url'=> $url]));
    }
}
