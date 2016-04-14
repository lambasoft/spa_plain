<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 5:44 PM
 */
require 'vendor/autoload.php';
require_once 'functions.php';

$errors = "";
$config = array(
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
$paths = explode($config['urls']['mainDir'],dirname(__FILE__));
defined("WEB_PATH") or define("WEB_PATH", $paths[1]  );

defined("RESOURCES_PATH") or define("RESOURCES_PATH", WEB_PATH . "resources");
defined("ACTIONS_PATH") or define("ACTIONS_PATH", WEB_PATH . "actions");
defined("STYLES_PATH") or define("STYLES_PATH", $config['paths']['resources']['css']);
defined("PLUGINS_PATH") or define("PLUGINS_PATH", WEB_PATH . "plugins");
defined("BOOTSTRAP_PATH") or define("BOOTSTRAP_PATH", $config['paths']['resources']['bootstrap']);

/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

$db = $config['db']['local'];

$dbh = new PDO(sprintf("mysql:host=%s;dbname=%s",$db['host'],$db['dbname']), $db['username'], $db['password']);

$config = new PHPAuth\Config($dbh);
$auth   = new PHPAuth\Auth($dbh, $config);

if($auth->isLogged()){
   $User = $auth->getUser($auth->getSessionUID($auth->getSessionHash()));
}