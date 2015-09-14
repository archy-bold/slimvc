<?php namespace tests;
// Settings to make all errors more obvious during testing
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/functions.php';

define('ROOT_PATH', __DIR__ . '/..');

require_once 'SlimTestCase.php';
