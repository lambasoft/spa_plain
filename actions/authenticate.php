<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 8:59 PM
 */
require_once("config.php");

class Authenticate{
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
        "login" => array(
            "email" => array(
                "required" => true,
                "validation" => FILTER_VALIDATE_EMAIL
            ),
            "password" => array(
                "required" => true
            )
        )
    );

    var $errors;
    var $post;
    var $auth;

    function Authenticate($auth){
        $this->auth = $auth;
    }

    function Register(){
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

        $register = $this->auth->register($info['email'], $info['password'],  $info['password_confirmation'], $extras , NULL, false);

        if(isset($register['error']) && ((int) $register['error'] >= 1)){
            $this->errors['error'] = $register['message'];
        }

        return true;
    }

    function Login(){
        if(!isset($_POST['token'])){
            return false;
        }

        $info = $this->getPostInfo("login");
        $this->post = $info;
        if(!$this->validatePost($info, "login")){
            return false;
        }

        $login = $this->auth->login($info['email'], $info['password']);

        if(isset($login['error']) && ((int) $login['error'] >= 1)){
            $this->errors['error'] = $login['message'];
        }

        return true;
    }

    function old($value){
        if(isset($this->post[$value])){
            return strip_tags($this->post[$value]);
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
