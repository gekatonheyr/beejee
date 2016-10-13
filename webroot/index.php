<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT.DS.'views');

require_once(ROOT.DS.'lib'.DS.'autoload.php');

session_start();

$kernel = new App();
$kernel->handle($_SERVER['REQUEST_URI']);