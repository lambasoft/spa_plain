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


function getIPInfo($ip){
  $url = "http://freegeoip.net/json/$ip";
  $ch  = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
  $data = curl_exec($ch);
  curl_close($ch);

  if ($data) {
    $data = json_decode($data);
    return $data;
  }
  return array();
}
