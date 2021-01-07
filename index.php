<?php
//directory seperator is "\"
define('DS',DIRECTORY_SEPARATOR);

//full path from user root example D:\programmer\Programs\Xammp\htdocs\PROJECTS\Personal\Salad Maker\Project_testing
define('ROOT',dirname(__FILE__));
require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'app' . DS . 'lib'. DS . 'helpers'. DS .'helpers.php');


//Autoload classes
function loadCore($class) {
    $path = ROOT . DS . 'core' . DS  . $class . '.php';
    if(!file_exists($path)){
        return false;
    }
    require_once $path;
}

function loadController($class){
    $path = ROOT . DS . 'app' . DS  . 'controllers' . DS . $class . '.php';
    if(!file_exists($path)){
        return false;
    }
    require_once $path;
}

function loadModel($class){
    $path = ROOT . DS . 'app' . DS  . 'models' . DS . $class . '.php';
    if(!file_exists($path)){
        return false;
    }
    require_once $path;
}

function loadViews($class){
    $path = ROOT . DS . 'app' . DS  . 'views' . DS . $class . '.php';
    if(!file_exists($path)){
        return false;
    }
    require_once $path;
}

//load all autoloaders
spl_autoload_register('loadCore');
spl_autoload_register('loadController');
spl_autoload_register('loadModel');
spl_autoload_register('loadViews');
// Load Composer's autoloader
require 'vendor/autoload.php';

//path info will get the path after the project_testing in
//http://localhost/projects/Personal/Salad%20Maker/Project_testing/
//so if we put users after project_testing the output will be 
// "/users"



// so if we put users after project_testing the output will be 
// users because we exploded the "/" from the string
$url = isset($_SERVER['PATH_INFO']) ? explode('/',ltrim($_SERVER['PATH_INFO'],'/')): [];

Router::route($url);
