<?php
require '../vendor/autoload.php';
require 'functions.php';

define('ROOT_PATH', __DIR__ . '/..');

// Register Smarty for views
$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig(),
    'templates.path' => ROOT_PATH . '/resources/views',
));

// Set options
$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => ROOT_PATH . '/storage/views',
);
