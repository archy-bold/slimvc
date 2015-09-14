<?php namespace App\Exception;

class RouteException extends \Exception{

	const INVALID_CONTROLLER_DESTINATION = 601;
	const MISSING_CONSTRUCTOR            = 602;
	const MISSING_CONSTRUCTOR_METHOD     = 603;
	
	public function __construct($message, $code, \Exception $previous = null){
		parent::__construct($message, $code, $previous);
    }

    public static function getInvalidController($message){
    	return new self($message, self::INVALID_CONTROLLER_DESTINATION);
    }

    public static function getMissingConstructor($message){
    	return new self($message, self::MISSING_CONSTRUCTOR);
    }

    public static function getMissingConstructorMethod($message){
    	return new self($message, self::MISSING_CONSTRUCTOR_METHOD);
    }

}
