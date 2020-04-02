<?php
/* Маршрутизатор нашего MVC */

namespace app\core;

use app\core\View;

class Route {

	public $routeMap = [];
	public $params = [];

	public function __construct()
	{
		$arr = require 'app/config/config.php';
		foreach ($arr as $key => $val) 
		{
			$this->addRouter($key, $val);
		}
	}

	public function addRouter($route, $params) 
	{
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
		$route = '#^'.$route.'$#';
		$this->routeMap[$route] = $params;
	}

	public function matchRouter()
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');
		foreach ($this->routeMap as $route => $params)
		{
			if(preg_match($route, $url, $matches))
			{
			    foreach ($matches as $key=>$match)
                {
                    if(is_string($key))
                    {
                        if(is_numeric($match))
                        {
                            $match = (int)$match;
                        }
                        $params[$key] = $match;
                    }
                }
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	public function startRouter() 
	{
		if($this->matchRouter())
		{
			$path = 'app\controllers\\'. ucfirst($this->params['controllers']). 'Controller';
			 if(class_exists($path)) 
			 {
				$action = $this->params['action'] .'Action';

				if(method_exists($path, $action))
				{
					$controllers = new $path($this->params);
					$controllers->$action();

				} else echo 'Экшн не был найден!';

			 } else echo 'Такого класса не существует';

		} else View::errorType(404);
	}
}
