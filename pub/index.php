<?php

require_once '../App/Config.php';
require_once '../Core/Autoloader.php';

define('BP', dirname(__DIR__) . DS);

use Core\Autoloader;
use App\Application;

Autoloader::init();
session_start();

$app = new Application();
$app->start();
