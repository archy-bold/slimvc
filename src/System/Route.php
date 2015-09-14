<?php namespace App\System;

use App\Exception\RouteException;

class Route{

	protected $controllers = array();

	protected function __construct(){
		
	}
	
	public static function get($route, $destination){
		$routeObj = self::getInstance();
		$callable = $routeObj->getCallable($destination);
		app()->get($route, $callable);
	}
	
	public static function post($route, $destination){
		$routeObj = self::getInstance();
		$callable = $routeObj->getCallable($destination);
		app()->post($route, $callable);
	}

	protected function getController($destination){
		$controllerStr = substr($destination, 0, strpos($destination, '@'));

		if (empty($controllerStr)){
			throw RouteException::getInvalidController("Invalid controller destination given, must be in format "
				. "'Countroller@method'.");
		}

		$controller = null;
		if (!array_key_exists($controllerStr, $this->controllers)){
			// We've not instantiated this controller yet. Do that.
			$className = 'App\\Controller\\' . $controllerStr;
			if (!class_exists($className)){
				throw RouteException::getMissingConstructor("The given controller, $className, doesn't exist. "
					. "It either needs to be created in src\\Controller\\ or the spelling is incorrect.");
			}

			$this->controllers[$controllerStr] = new $className;
		}
		
		return $this->controllers[$controllerStr];
	}

	protected function getCallable($destination){
		$controller = $this->getController($destination);

		$method = substr($destination, strpos($destination, '@') + 1);

		if (empty($method)){
			throw RouteException::getInvalidController("Invalid controller destination given, must be in format "
				. "'Countroller@method'.");
		}

		if (!method_exists($controller, $method)){
			throw RouteException::getMissingConstructorMethod("The given method, $method, does not exist on the controller.");
		}
		
		return array($controller, $method);
	}

	/**
	 * Instantiate the singleton Route.
	 */
	protected static function getInstance(){
		static $instance = null;

		// Instantiate if null.
		if (null === $instance) {
			$instance = new static();
		}

		return $instance;
	} 	

}
