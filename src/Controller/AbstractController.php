<?php namespace App\Controller;

class AbstractController{
	

	protected function render($view, $properties){
		app()->render($view, $properties);
	}

}
