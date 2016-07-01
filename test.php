<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/15/16
 * Time: 2:43 PM
 */
require_once("config.php");
$spa = new Spa($DB);
$info = array(
	"create" => array(
		"name" => array(
			"required" => true,
			"input_name" => "first_name"
			),
		"logo" => array(
			"required" => false
			)
		)
	);
$spa = new FormBuilder($spa, "create", ["action" => "path_goes_here"]);
echo "<pre>";
print_r($spa->configs);
echo "</pre>";
echo "<pre>";
print_r($spa->inputs);
echo "</pre>";
echo $spa->render(true);