<?php

require_once("config.php");
use Respect\Validation\Validator as v;

//Spa Class
//Requires: Medoo Framework
//Requires: Respect\Validation\Validator
Class Spa{

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
			"address" => array(
				"required" => true
			),
			"images" => array(
				"type" => "multi_upload",
				"count" => "3",
				"required" => false,
				"input_type" => "file"
			),
			"treatment_menu" => array(
				"required" => false,
				"input_type" => "file"
			),
			"manager_name" => array(
				"required" => true,
				"input_label_text" => "Manager's Name"
			),
			"opening_hours" => array(
				"required" => true,
				"input_type" => "div",
				"input_class" => "row",
				"input_style" => "margin-left: 10px;",
				"input_id" => "businessHoursContainer"
			),
			"openingHours" => array(
				"required" => false,
				"input_type" => "hidden",
				"input_name" => "opening_hours",
				"input_id" => "openingHours"
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
			"treatment_rooms" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"],
				"validation_error" => "This input should be a number",
				"input_label_text" => "Number of Treatment Rooms"
			),
			"retail_products" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"],
				"validation_error" => "This input should be a number"
			),
			"prof_products" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"],
				"validation_error" => "This input should be a number",
				"input_label_text" => "Professional Products "
			),
			"description" => array(
				"input_type" => "textarea",
				"input_label_text" => "Overview",
				"required" => true
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
		),
		"login" => array(
			"email" => array(
				"required" => true,
				"validation" => ["filter" => FILTER_VALIDATE_EMAIL]
			),
			"password" => array(
				"required" => true
			)
		),
		"review" => array(
			"link_user_id" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+$/"]
			),
			"rating" => array(
				"required" => true,
				"validation" => ["regex" => "/^[0-9]+(\.[0-9]{1,2})?$/"] //Decimal
			),
			"title" => array(
				"required" => true
			),
			"description" => array(
				"required" => true
			)
		)
	);


	function test($data){
		$userValidator = v::optional(v::key('name', v::stringType()->length(1,32)));

		return $userValidator->validate($data); // true
	}


	function Spa($DB, $id = NULL){
		if($DB instanceof Medoo){
			$this->DB = $DB;
		}

		if(isset($id)){
			if(count($this->DB->select("spa","id",["id" => $id])) > 0){
				$this->id = (int)$id;
			}else{
				$this->errors['error'] = "Spa Not Found";
			}
		}
	}

	function getAll(){
		return $this->DB->select("spa","*",["LIMIT" => 10 ]);
	}

	function getReviewsCount(){
		return $this->DB->count("reviews", ["AND" => ["link_id" => $this->id, "type" => "spa"]]);
	}

	function getReviewsAvg(){
		return $this->DB->avg("reviews", "rating",["AND" => ["link_id" => $this->id, "type" => "spa"]] );
	}

	function getReviews(){
		return $this->DB->select("reviews","*",[ "AND" => ["link_id" => $this->id, "type" => "spa"], "LIMIT" => 10 ]);
	}

	function getID($id = NULL){
		if(!isset($id) && isset($this->id)){
			$id = $this->id;
		}
		$results = $this->DB->select("spa","*",["id" => $id, "LIMIT" => 1]);
		return reset($results);
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
					if(preg_match($info['validation']['regex'],$data[$column]) == false && !empty($data[$column])) {
						if(isset($info['validation_error'])){
							$this->errors[$column] = $info['validation_error'];
						}else{
							$this->errors[$column] = ucwords(strtolower(str_replace("_"," ",$column))) . " is not valid!";
						}

						continue;
					}
					break;

					case "filter":
					if(filter_var($data[$column], $info['validation']['filter']) === false && !empty($data[$column])) {
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
		if(isset($info) && $this->validate($info,$action)){
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

				if (!empty($_FILES['images'])) {
					$files = array();
					foreach ($_FILES['images'] as $k => $l) {
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
						echo $handle->file_dst_pathname . "|";
						unset($handle);
					}
				}

				$id = $this->DB->insert("spa", $info);
				if($id > 0){
					$this->id = $id;
					return true;
				}

				return false;

				break;

				case "review":
				$info['type'] = "spa";
				$info['link_id'] = $this->id;
				$id = $this->DB->insert("reviews", $info);

				if($id > 0){
					return true;
				}
				break;
			}
		}else{
			return false;
		}

	}
}
