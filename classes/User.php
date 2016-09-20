<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 8:59 PM
 */
require_once("config.php");

class User extends PHPAuth\Auth{

    var $errors = array();
    var $columns = array(
        "register" => array(
            "email" => array(
                "required" => true,
                "validation" => FILTER_VALIDATE_EMAIL
                ),
            "first_name" => array(
                "required" => true
                ),
            "last_name" => array(
                "required" => true
                ),
            "password" => array(
                "required" => true
                ),
            "password_confirmation" => array(
                "required" => true
                ),
            ),
        "update" => array(
            "email" => array(
                "required" => true,
                "validation" => FILTER_VALIDATE_EMAIL
                ),
            "first_name" => array(
                "required" => true
                ),
            "last_name" => array(
                "required" => true
                )
            ),
        "login" => array(
            "email" => array(
                "required" => true,
                "validation" => FILTER_VALIDATE_EMAIL
                ),
            "password" => array(
                "required" => true
                )
            ),
        "activate" => array(
            "ver_code" => array(
                "required" => true
                )
            ),
        "reset_password" => array(
            "email" => array(
                "required" => true
                )
            ),
        "change_password" => array(
            "code" => array(
                "required" => true
                ),
            "password" => array(
                "required" => true
                ),
            "password_confirmation" => array(
                "required" => true
                ),

            ),
        "update_password" => array(
            "current_password" => array(
                "required" => true
                ),
            "password" => array(
                "required" => true
                ),
            "password_confirmation" => array(
                "required" => true
                ),

            )
        );
    var $post;
    var $User;

    function User($dbh,$config, $MEDOO = NULL){
        parent::__construct($dbh,$config);
        $this->DB = $MEDOO;
        if($this->isLogged()){
            $this->setUserInfo($this->getUser($this->getSessionUID($this->getSessionHash())));
        }
    }

    function update($info, $action = "update"){
        if(isset($info)){
            switch($action){
                case "update":
                $info = $this->getPostInfo($action);
                $this->post = $info;
                if(!$this->validatePost($info, $action)){
                    return false;
                }

                $this->DB->update("users", $info, [ "id" => $this->getSessionUID($this->getSessionHash()) ] );
                return true;

                break;

                case "update_password":
                $results =  $this->changePassword($this->getSessionUID($this->getSessionHash()),$info['current_password'],$info['password'],$info['password_confirmation']);
                if(isset($results['error']) && ((int) $results['error'] >= 1)){
                    if (strpos(strtolower($results['message']), 'current') !== false) {
                       $this->errors['current_password'] = $results['message'];
                   }else{
                       $this->errors['password'] = $results['message'];
                   }

                   return false;
               }
               return true;
               break;
           }

       }
   }


   function doRegister(){
    if(!isset($_POST['token'])){
        return false;
    }


    $info = $this->getPostInfo();
    $this->post = $info;
    if(!$this->validatePost($info)){
        return false;
    }

    $extras = $info;
    unset($extras['email']);
    unset($extras['password']);
    unset($extras['password_confirmation']);

    $register = $this->register($info['email'], $info['password'],  $info['password_confirmation'], $extras , NULL, true);



    if(isset($register['error']) && ((int) $register['error'] >= 1)){
        $this->errors['error'] = $register['message'];
        return false;
    }

    return true;
}

function doLogin(){
    if(!isset($_POST['token'])){
        return false;
    }

    $info = $this->getPostInfo("login");
    $this->post = $info;
    if(!$this->validatePost($info, "login")){
        return false;
    }

    $login = $this->login($info['email'], $info['password']);

    if(isset($login['error']) && ((int) $login['error'] >= 1)){
        $this->errors['error'] = $login['message'];
        return false;
    }

    $this->setUserInfo($this->getUser($this->getSessionUID($login['hash'])));

    return true;
}


function doActivate(){
    if(!isset($_POST['token'])){
        return false;
    }
    $info = $this->getPostInfo("activate");
    $this->post = $info;
    if(!$this->validatePost($info, "activate")){
        return false;
    }

    $activate = $this->activate($info['ver_code']);

    if(isset($activate['error']) && ((int) $activate['error'] >= 1)){
        $this->errors['error'] = $activate['message'];
        return false;
    }

    return true;

}

function doResetPassword(){
    if(!isset($_POST['token'])){
        return false;
    }
    $info = $this->getPostInfo("reset_password");
    $this->post = $info;
    if(!$this->validatePost($info, "reset_password")){
        return false;
    }

    $activate = $this->requestReset($info['email'], true);

    if(isset($activate['error']) && ((int) $activate['error'] >= 1)){
        $this->errors['error'] = $activate['message'];
        return false;
    }

    return true;

}


function doResetChangePassword(){
    if(!isset($_POST['token'])){
        return false;
    }
    $info = $this->getPostInfo("change_password");
    $this->post = $info;
    if(!$this->validatePost($info, "change_password")){
        return false;
    }

    $change = $this->resetPass($info['code'],$info['password'],$info['password_confirmation']);

    if(isset($change['error']) && ((int) $change['error'] >= 1)){
        $this->errors['error'] = $change['message'];
        return false;
    }

    return true;

}

function setUserInfo($info){
    foreach($info as $key=>$infoObj){
        $this->{$key} = $infoObj;
        if(isset($this->columns['update'][$key])){
            $this->columns['update'][$key]['default'] = $infoObj;
        }
    }
}

function get($key){
    if(isset($this->{$key})){
        return $this->{$key};
    }
}

function old($value){
    if(isset($this->post[$value])){
        return strip_tags($this->post[$value]);
    }
}

function setPost($key,$value){
    $this->post[$key] = $value;
    return true;
}

function parseActivate(){
    if(isset($_GET['email'])){
        if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
            $this->setPost("email", $_GET['email']);
        }
    }
    if(isset($_GET['code'])){
        if(ctype_alnum($_GET['code'])){
            $this->setPost("ver_code", $_GET['code']);
        }
    }
}
function parseReset(){
    if(isset($_GET['code']) && ctype_alnum($_GET['code'])){
        $this->setPost("code", $_GET['code']);
    }else{
        $this->errors['error'] = "Invalid Reset Code";
    }
}

function getPostInfo($column = "register"){
    foreach($_POST as $key=>$post){
        if(!in_array($key, array_keys($this->columns[$column]))){
            unset($_POST[$key]);
        }
    }

    return $_POST;
}

function validatePost($post, $column = "register"){
    foreach($this->columns[$column] as $column=>$info){
        if(isset($info['required']) && $info['required'] == true){
            if(!isset($post[$column]) || $post[$column] == ""){
                $this->errors[$column] = $column . " is required!";
                continue;
            }
        }

        if(isset($info['validation'])){
            if (filter_var($post[$column], $info['validation']) === false) {
                $this->errors[$column] = $column . " is not valid!";
                continue;
            }
        }
    }

    if(empty($this->errors)){
        return true;
    }

    return false;
}

}
