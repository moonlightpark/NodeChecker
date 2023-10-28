<?php
/*****************************************************
 * http://jream.com/lab open source Framework
 *****************************************************/
require 'config/global.php';
require 'config/env.php';

define('__APPLICATION_PATH__', '');

spl_autoload_register('Autoloader');

function Autoloader($class)
{

    require "libs/" . $class .".php";
}

$bootstrap = new WBootstrap();
$bootstrap->init();


