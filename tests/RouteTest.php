<?php

use App\Exception\RouteException;
use App\System\Route;

class RouteTest extends SlimTestCase{

    public function testGetInvalidController(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::INVALID_CONTROLLER_DESTINATION);

        // Test with a malformed destination.
        route()->get('/', '@function');
    }

    public function testGetInvalidController2(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::INVALID_CONTROLLER_DESTINATION);

        // Test with a different malformed destination.
        route()->get('/', 'test');
    }

    public function testGetInvalidControllerEmpty(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::INVALID_CONTROLLER_DESTINATION);

        // Test with an empty destination.
        route()->get('/', '');
    }

    public function testGetControllerMissing(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::MISSING_CONSTRUCTOR);

        // Test with an missing destination constructor.
        route()->get('/', 'Test@');
    }

    public function testGetInvalidControllerFunction(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::INVALID_CONTROLLER_DESTINATION);

        // Test with an empty destination function, but valid controller.
        route()->get('/', 'WelcomeController@');
    }

    public function testGetControllerFunctionMissing(){
        $this->setExpectedException('App\Exception\RouteException', '',
            RouteException::MISSING_CONSTRUCTOR_METHOD);

        // Test with a missing function on the controller.
        route()->get('/', 'WelcomeController@invalid');
    }

    //TODO This doesn't work, I'm getting an error when I instantiate a Slim app...
    // public function testGetWorks(){
    //     // Set a mock version of Route that replaces callable with an anonymous function.
    //     $routeMock = $this->getMockBuilder('App\System\Route')
    //         ->disableOriginalConstructor()
    //         ->setMethods(array('getCallable'))
    //         ->getMock();

    //     // Set the app property to be the test app.
    //     $reflection = new ReflectionClass($routeMock);
    //     $prop = $reflection->getProperty('app');
    //     $prop->setAccessible(true);

    //     $prop->setValue($routeMock, $this->app);

    //     $callback = function(){ echo 'test'; };

    //     $routeMock->expects($this->once())
    //         ->method('getCallable')
    //         ->will($this->returnValue($callback));

    //     $routeMock->get('/', 'WelcomeController@index');

    //     $this->expectOutputString('welcome');
    // }

}
