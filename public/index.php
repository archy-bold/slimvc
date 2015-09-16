<?php
require '../src/bootstrap.php';

/* ROUTES HERE */
$route = route();

$route->get('/', 'WelcomeController@index');

/* END ROUTES */


// Run app
$app->run();
