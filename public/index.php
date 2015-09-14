<?php
require '../src/bootstrap.php';
use App\System\Route;

/* ROUTES HERE */

Route::get('/', 'WelcomeController@index');

/* END ROUTES */


// Run app
$app->run();
