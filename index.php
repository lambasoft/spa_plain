<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 5:38 PM
 */
require_once("config.php");

$directory = "/";
$page = "home";

$dirs = array(
    "/" => array(
        "home" => array(
            "path" => "home"
            ),
        "spas" => array(
            "path" => "spas"
            ),
        "login" => array(
            "path" => "auth/login"
            ),
        "logout" => array(
            "path" => "auth/logout"
            ),
        "register" => array(
            "path" => "auth/register"
            ),
        "activate" => array(
            "path" => "auth/activate"
            ),
        "password_reset" => array(
            "path" => "auth/password_reset"
            ),
        "reset" => array(
            "path" => "auth/reset"
            ),
        "spa" => array(
            "path" => "spa"
            )
        ),
    "account" => array(
        "create_spa" => array(
            "path" => "create_spa"
            ),
        "create_gym" => array(
            "path" => "create_gym"
            ),
        "" => array(
            "path" => "index"
            )
        )
    );


if(isset($_GET['directory'])){
    if(isset($dirs[$_GET['directory']])){
        $directory = $_GET['directory'];
    }elseif(isset($configs['redirectOnNotFound'])){
        RedirectToURL(WEB_PATH . $configs['redirectOnNotFound']);
    }
}

if(isset($_GET['page']) && isset($dirs[$directory][$_GET['page']])){
    $page = $_GET['page'];
    $path = $dirs[$directory][$_GET['page']]['path'];
}elseif(isset($configs['redirectOnNotFound'])){
    RedirectToURL(WEB_PATH . $configs['redirectOnNotFound']);
}

include(VIEWS_PATH . "/" . $directory . "/" . $path . ".php") ;



