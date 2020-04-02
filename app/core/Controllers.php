<?php
namespace app\core;

use app\core\View;
use app\core\Models;

abstract class Controllers
{
	public $route;
	public $view;
	public $control;

	public function __construct($route)
	{
		$this->route = $route;
		if(!$this->checkControl())
        {
            View::errorType(403);
        }
		$this->view = new View($route);
		$this->model = $this->loadModels($route['controllers']);

    }

	public function loadModels($name)
	{
		$path = 'app\models\\' .ucfirst($name) . 'Model';
		if(class_exists($path))
		{
			return new $path;
		}
	}

	public function isControl($key)
    {
       return in_array($this->route['action'], $this->control[$key]);
    }

	public function checkControl()
    {
        $this->control = require 'app/config/control/' . $this->route['controllers'] . '.php';

        if($this->isControl('all'))
        {
            return true;
        }

        elseif ($this->isControl('guest'))
        {
            return true;
        }

        elseif ($_SESSION['auth_session'] && $this->isControl('user'))
        {
            return true;
        }

        elseif (($_SESSION['admin']['is_admin'] == 1) && $this->isControl('admin'))
        {
            return true;
        }

        return false;
    }
}