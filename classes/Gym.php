<?php

require_once("config.php");
use Respect\Validation\Validator as v;

//Gym Class
//Requires: Medoo Framework
//Requires: Respect\Validation\Validator
Class Gym{
	var $errors = array();
	var $columns = array(
		"create" => array(
			"name" => array(
				"required" => true,
				"input_label_text" => "Name"
			),
			"logo" => array(
				"required" => false
			),
			"images" => array(
				"type" => "multi_upload",
				"count" => "3",
				"required" => false,
				"input_type" => "file"
			),
			"location" => array(
				"required" => true,
				"input_type" => "div",
				"input_style" => "width: 300px; height: 200px;",
				"input_id" => "locationGUI",
				"input_label_text" => "Location",
				"validation" => ["regex" => "/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/"],
				"validation_error" => "Location is not valid"
			),
			"membership_benefits" => array(
				"required" => false,
				"input_type" => "file"
			),
			"classes" => array(
				"required" => false,
				"input_type" => "file"
			),
			"location_coord" => array(
				"required" => false,
				"input_type" => "hidden",
				"input_name" => "location",
				"input_id" => "locationGYM"
			),
			"manager_name" => array(
				"required" => true,
				"input_label_text" => "Manager's Name"
			),
			"opening_hours" => array(
				"required" => true
			),
			"equipments_used" => array(
				"required" => false,
				"input_id" => "tags"
			),
			"size" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"],
				"validation_error" => "This input should be a number",
				"input_label_text" => "Size (Square Meters)"
			),
			"open_year" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"],
				"validation_error" => "This input should be a number",
				"input_label_text" => "Opening Date"
			),
			"description" => array(
				"input_type" => "textarea",
				"required" => true,
				"input_label_text" => "Overview"
			),
			"website" => array(
				"validation" => ["filter" => FILTER_VALIDATE_URL],
				"required" => false
			),
			"social_facebook" => array(
				"validation" => ["filter" => FILTER_VALIDATE_URL],
				"required" => false
			),
			"social_twitter" => array(
				"validation" => ["filter" => FILTER_VALIDATE_URL],
				"required" => false
			),
			"social_instagram" => array(
				"validation" => ["filter" => FILTER_VALIDATE_URL],
				"required" => false
			),
			"contact_details" => array(
				"required" => false,
				"input_label_text" => "Contact Info"
			),
			"link_user_id" => array(
				"input_type" => "hidden"
			)
		)
	);


	function test($data){
		$userValidator = v::optional(v::key('name', v::stringType()->length(1,32)));

		return $userValidator->validate($data); // true
	}


	function Gym($DB){
		if($DB instanceof Medoo){
			$this->DB = $DB;
		}
	}

	private function validate(&$data,$action){
		$data = array_intersect_key($data,$this->columns[$action]);
		foreach($this->columns[$action] as $column=>$info){
			if(isset($info['required']) && $info['required'] == true){
				if(!isset($data[$column]) || empty($data[$column])){
					$this->errors[$column] = ucwords(strtolower(str_replace("_"," ",$column))) . " is required!";
					continue;
				}
			}

			if(isset($info['validation']) && is_array($info['validation'])){
				switch(array_keys($info['validation'])[0]){
					case "regex":
					if(preg_match($info['validation']['regex'],$data[$column]) == false) {
						if(isset($info['validation_error'])){
							$this->errors[$column] = $info['validation_error'];
						}else{
							$this->errors[$column] = ucwords(strtolower(str_replace("_"," ",$column))) . " is not valid!";
						}

						continue;
					}
					break;

					case "filter":
					if(filter_var($data[$column], $info['validation']['filter']) === false) {
						if(isset($info['validation_error'])){
							$this->errors[$column] = $info['validation']['validation_error'];
						}else{
							$this->errors[$column] = ucwords(strtolower(str_replace("_"," ",$column))) . " is not valid!";
						}
						continue;
					}
					break;
				}

			}
		}

		if(empty($this->errors)){
			return true;
		}else{
			return false;
		}
	}

	function doAction($action, $info){

		if(isset($info) && $this->validate($info,"create")){
			switch($action){
				case "create":
				if(isset($_FILES['logo'])){
					$image = new Bulletproof\Image($_FILES);

					if($image["logo"]){
						$image->setLocation("uploads");
						$upload = $image->upload();
						if($upload){
							$info['logo'] = $image->getFullPath();
						}else{
							$this->errors['logo'] = $image["error"];
							return false;
						}
					}
				}

				if (!empty($_FILES['files'])) {
					$files = array();
					foreach ($_FILES['files'] as $k => $l) {
						foreach ($l as $i => $v) {
							if (!array_key_exists($i, $files)) $files[$i] = array();
							$files[$i][$k] = $v;
						}
					}

					foreach ($files as $file) {
						$handle = new upload($file);
						if ($handle->uploaded) {
							$handle->Process("uploads");
							if ($handle->processed) {
								$info['file'] = $handle->file_dst_pathname;
							} else {
								//echo 'Error: ' . $handle->error;
							}
						} else {
							//echo 'Error: ' . $handle->error;
						}
						unset($handle);
					}
				}

				$id = $this->DB->insert("gym", $info);
				if($id > 0){
					return true;
				}

				return false;

				break;
			}

		}
	}
}
