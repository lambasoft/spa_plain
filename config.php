<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 5:44 PM
 */
require 'vendor/autoload.php';
require_once 'functions.php';
require_once 'actions/User.php';

$errors = "";
$configs = array(
    "db" => array(
        "local" => array(
            "dbname" => "spa_plain",
            "username" => "root",
            "password" => "",
            "host" => "127.0.0.1"
        )
    ),
    "urls" => array(
        "mainDir" => "spa_plain",
        "baseUrl" => "http://localhost/"
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
    )
);

/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
$paths = explode($configs['urls']['mainDir'],dirname(__FILE__));
defined("WEB_PATH") or define("WEB_PATH", $configs['urls']['mainDir'] .  $paths[1]  );
defined("RESOURCES_PATH") or define("RESOURCES_PATH", "resources");
defined("ACTIONS_PATH") or define("ACTIONS_PATH", "actions");
defined("STYLES_PATH") or define("STYLES_PATH", $configs['paths']['resources']['css']);
defined("PLUGINS_PATH") or define("PLUGINS_PATH", "plugins");
defined("BOOTSTRAP_PATH") or define("BOOTSTRAP_PATH",  $configs['paths']['resources']['bootstrap']);

/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

$db = $configs['db']['local'];

$dbh = new PDO(sprintf("mysql:host=%s;dbname=%s",$db['host'],$db['dbname']), $db['username'], $db['password']);

$config = new PHPAuth\Config($dbh);
//$auth   = new PHPAuth\Auth($dbh, $config);
$User = new User($dbh, $config);


//if($User->auth->isLogged()){
//   $User = $auth->getUser($auth->getSessionUID($auth->getSessionHash()));
//}