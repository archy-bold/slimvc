<?php

use App\System\Route;

class RouteTest extends \PHPUnit_Framework_TestCase{

    public function testGetInstance(){
    	// Use reflection to make this protected function accessible.
		$class = new ReflectionClass('App\System\Route');
		$method = $class->getMethod('getInstance');
		$method->setAccessible(true);

    	// Call the function twice, should get the same instance both times.
    	$route1 = $method->invoke(null);
    	$route2 = $method->invoke(null);

    	$this->assertInstanceOf('App\System\Route', $route1);
    	$this->assertInstanceOf('App\System\Route', $route2);
    	$this->assertEquals($route1, $route2);
    }
}
