<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 5:44 PM
 */

// error_reporting(0);
// ini_set('error_reporting', 0);
// ini_set("display_errors", 0);

require 'vendor/autoload.php';
require_once 'functions.php';

//TODO: Add an autoload for the custom classes folder
require_once 'classes/User.php';
require_once 'classes/Spa.php';
require_once 'classes/Gym.php';
require_once 'classes/FormBuilder.php';

$errors = "";
$configs = array(
    "db" => array(
        "local" => array(
            "dbtype" => "mysql",
            "dbname" => "spa_plain",
            "username" => "root",
            "password" => "",
            "host" => "127.0.0.1",
            "charset" => "utf8",
        )
    ),
    "urls" => array(
        "mainDir" => "/spa_plain",
        "baseUrl" => "http://localhost"
    ),
    "paths" => array(
        "resources" => array(
            "css" => "resources/css",
            "bootstrap" => "vendor/twbs/bootstrap",
        ),
        "plugins" => array(
            "sweetalert" => "sweetalert"
        ),
        "images" => array(
            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
        )
    ),
    "redirectOnNotFound" => "/home"
);


// Initialize Medoo
$DB = new medoo([
    'database_type' => $configs['db']['local']['dbtype'],
    'database_name' => $configs['db']['local']['dbname'],
    'server' => $configs['db']['local']['host'],
    'username' => $configs['db']['local']['username'],
    'password' => $configs['db']['local']['password'],
    'charset' => $configs['db']['local']['charset']
]);


/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
$paths = explode($configs['urls']['mainDir'],dirname(__FILE__));
defined("WEB_PATH") or define("WEB_PATH", $configs['urls']['baseUrl'] . $configs['urls']['mainDir'] .  $paths[1]  );
defined("RESOURCES_PATH") or define("RESOURCES_PATH", "resources");
defined("VIEWS_PATH") or define("VIEWS_PATH",  "views");
defined("ACTIONS_PATH") or define("ACTIONS_PATH", "actions");
defined("STYLES_PATH") or define("STYLES_PATH", $configs['paths']['resources']['css']);
defined("PLUGINS_PATH") or define("PLUGINS_PATH", "plugins");
defined("BOOTSTRAP_PATH") or define("BOOTSTRAP_PATH",  $configs['paths']['resources']['bootstrap']);



$db = $configs['db']['local'];

$dbh = new PDO(sprintf("mysql:host=%s;dbname=%s",$db['host'],$db['dbname']), $db['username'], $db['password']);
$config = new PHPAuth\Config($dbh);
//$auth   = new PHPAuth\Auth($dbh, $config);
$User = new User($dbh, $config, $DB);


//if($User->auth->isLogged()){
//   $User = $auth->getUser($auth->getSessionUID($auth->getSessionHash()));
//}

/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);
