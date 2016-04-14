<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 5:38 PM
 */
require_once("config.php");

$page = "home";
if(isset($_GET['page'])){
    switch($_GET['page']){
        case "home":
            $page = "home";
            break;
        case "login":
            $page = "auth/login";
            break;
        case "register":
            $page = "auth/register";
            break;
        case "password_reset":
            $page = "auth/password_reset";
            break;
    }

}

include(RESOURCES_PATH . "/views/" . $page . ".php") ;


