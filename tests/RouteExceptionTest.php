<?php

use App\Exception\RouteException;

class RouteExceptionTest extends \PHPUnit_Framework_TestCase{

    public function testConstructor(){
        $message = "test";
        $code = 1;
        $last = new \Exception;

        $exception = new RouteException($message, $code, $last);

        $this->assertEquals($exception->getMessage(), $message);
        $this->assertEquals($exception->getCode(), $code);
        $this->assertEquals($exception->getPrevious(), $last);
    }

    public function testConstructorNullPrevious(){
        $message = "test";
        $code = 1;

        $exception = new RouteException($message, $code);

        $this->assertEquals($exception->getMessage(), $message);
        $this->assertEquals($exception->getCode(), $code);
        $this->assertNull($exception->getPrevious());
    }

    public function testGetInvalidController(){
        $message = "test";
        $exception = RouteException::getInvalidController($message);

        $this->assertEquals($exception->getMessage(), $message);
        $this->assertEquals($exception->getCode(), RouteException::INVALID_CONTROLLER_DESTINATION);
    }

    public function testGetMissingConstructor(){
        $message = "test";
        $exception = RouteException::getMissingConstructor($message);

        $this->assertEquals($exception->getMessage(), $message);
        $this->assertEquals($exception->getCode(), RouteException::MISSING_CONSTRUCTOR);
    }

    public function testGetMissingConstructorMethod(){
        $message = "test";
        $exception = RouteException::getMissingConstructorMethod($message);

        $this->assertEquals($exception->getMessage(), $message);
        $this->assertEquals($exception->getCode(), RouteException::MISSING_CONSTRUCTOR_METHOD);
    }

}
