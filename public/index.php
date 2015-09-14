<?php
require '../src/bootstrap.php';
use App\System\Route;

/* ROUTES HERE */
$route = route();

$route->get('/', 'WelcomeController@index');

/* END ROUTES */


// Run app
$app->run();
