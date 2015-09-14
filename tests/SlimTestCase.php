<?php

use \Slim\Slim;

class SlimTestCase extends \PHPUnit_Framework_TestCase
{
    protected $app;

    // Run for each unit test to setup our slim app environment
    public function setup(){
        global $currentTest;

        // Establish a local reference to the Slim app object
        $this->app = $this->getSlimInstance();

        $currentTest = $this;
    }

    // Instantiate a Slim application for use in our testing environment. You
    // will most likely override this for your own application.
    public function getSlimInstance()
    {
        $app = new \Slim\Slim(array(
            'version' => '0.0.0',
            'debug'   => false,
            'mode'    => 'testing',
            'view' => new \Slim\Views\Twig(),
            'templates.path' => ROOT_PATH . '/resources/views',
        ));

        // Set options
        $view = $app->view();
        $view->parserOptions = array(
            'debug' => false,
            'cache' => ROOT_PATH . '/storage/views',
        );

        // force to overwrite the App singleton, so that \Slim\Slim::getInstance()
        // returns the correct instance.
        $app->setName('default');

        return $app;
    }

}
