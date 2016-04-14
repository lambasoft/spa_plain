<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/14/16
 * Time: 9:41 PM
 */

function RedirectToURL($url){
    header("Location: $url");
    exit;
}
