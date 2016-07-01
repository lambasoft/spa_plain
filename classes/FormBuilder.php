<?php
Class FormBuilder {

	var $_options = array(
		"input_name" => array(),
		"input_type" => array(),
		"input_style" => array(),
		"input_id" => array(),
		"input_class" => array("default" => "form-control"),
		"input_placeHolder" => array(),
		"required" => array("default" => "true"),
		"input_label_text" => array(),
		"type" => array(),
		"count" => array()
		);

	var $configs = array(
		"file_upload_tags" => array(
			"logo","image","picture","pic"
			)
		);

	var $errors = [];
	var $button = "";

	function FormBuilder($class, $action = "create", $settings = array()){
		if(isset($class->columns[$action]) && !empty($class->columns[$action])){
			$this->class = $class;
			$this->action = $action;
			$this->elements = $this->validate($class->columns[$action], $settings);
			$this->inputs = $this->build();
			if(isset($_POST)){
				$this->post = $_POST;
			}		

		}else{
			$this->errors['error'] = "Invalid Class";
		}
	}

	private function old($value){
		if(isset($this->post[$value])){
			return strip_tags($this->post[$value]);
		}elseif(isset($this->elements[$value]['default'])){
			return strip_tags($this->elements[$value]['default']);
		}
	}

	private function validate($elements,$settings){
		if(isset($settings)){
			foreach($settings as $validator=>$option){
				switch($validator){
					case "action":
					$this->configs['action'] = $option;
					break;

					case "action_path":
					$this->configs['action_path'] = $option;
					break;

					case "errors":
					foreach($option as $input=>$error){
						$this->inputs[$input]['error'] = $error;
					}
					break;

					case "button":
					$this->button = $option;
					break;

					case "enctype":
					$this->configs['enctype'] = $option;
					break;
				}
			}
		}
		return $elements;
	}


	function build(){
		if(isset($this->elements) && empty($this->errors)){
			$counter = 0;
			foreach($this->elements as $element=>$options){
				$counter++;
				$inputs[$element] = array_intersect_key($options,$this->_options);
				$diffs = array_diff(array_keys($this->_options),array_keys($options));

				//Check for Error from Validation
				if(isset($this->inputs[$element]['error'])){
					$inputs[$element]['error'] = $this->inputs[$element]['error'];
				}

				foreach($diffs as $diff){
					if(isset($this->_options[$diff]['default']) && empty($element)){
						$inputs[$element][$diff] = $this->_options[$diff]['default'];
						continue;
					}

					switch($diff){
						case "required":
						$inputs[$element][$diff] = $element;
						break;


						case "input_name":
						$inputs[$element][$diff] = $element;
						break;

						case "input_type":
						if(in_array($element, $this->configs['file_upload_tags'])){
							$inputs[$element][$diff] = "file";
						}else{
							$inputs[$element][$diff] = "text";
						}
						break;

						case "input_id":
						$inputs[$element][$diff] = '$id_' . $counter . "_" . $element ;
						break;

						case "input_placeHolder":
						$inputs[$element][$diff] = "Please Enter " . ucfirst(strtolower(str_replace("_"," ",$element)));
						break;

						case "input_label_text":
						$inputs[$element][$diff] = ucwords(strtolower(str_replace("_"," ",$element)));
						break;
					}
				}
			}

			return $inputs;
		}
	}


	public function addElement($info){
		if(isset($info) && is_array($info)){
			if(!isset($this->elements[key($info[0])])){
				$this->elements[] = $info;
			}else{
				$this->errors['addElement'] = "Element " . key($info[0]) . " already exist";
				return false;
			}
		}
	}

	private function getSubmitHtml($text = ""){
		$html = "<button type='submit' class='btn btn-primary'>";
		$html .= (empty($text) ?  ucfirst($this->action) . " " . ucfirst(get_class($this->class)) : $text );
		$html .= "</button>";
		return $html;
	}

	public function getInputToken($salt= "1234"){
		$hash = md5(mt_rand(1,1000000) . $salt . mt_rand(1,100000));
		$_SESSION['csrf_hash'] = $hash;
		$html = "<input type='hidden' name='token' value='" . $hash . "'>";
		if(isset($this->configs['action'])){
			$html .= "<input type='hidden' name='action_token' value='" . $this->configs['action'] . "'>";
		}
		return $html;
	}



	private function getElementHtml($name, $value){
		if(!(isset($value['input_type']) && $value['input_type'] == "hidden")){
			$html = "<div class='form-group " . (!empty($value['error']) ? ' has-error': '') . "' >";
			$html .= "<label class='control-label'>" . $value['input_label_text'] . "</label> " .  (($value['required'] == true) ? "*" : "");
		}
		


		switch($value['input_type']){
			case "text":
			$html .= "<input type='text' class='form-control' name='" . $value['input_name'] . "' value='" . $this->old($name) . "'> ";
			break;

			case "textarea":
			$html .= "<textarea class='form-control'  name='" . $value['input_name'] . "'  rows='5'>" . $this->old($name) . "</textarea>";

			break;


			case "div":
			$extra = "";
			if(isset($value['input_style'])){
				$extra .= " style='{$value['input_style']}'";
			}

			if(isset($value['input_id'])){
				$extra .= " id='{$value['input_id']}'";
			}
			if(isset($value['input_class'])){
				$extra .= " class='{$value['input_class']}'";
			}
			if(isset($value['input_name'])){
				$extra .= " class='{$value['input_name']}'";
			}
			
			$html .= "<div value='" . $this->old($name) . "' {$extra} ></div>";
			break;

			case "hidden":
			$extra = "";
			if(isset($value['input_id'])){
				$extra = " id='{$value['input_id']}'";
			}
			if(isset($value['input_class'])){
				$extra = " class='{$value['input_class']}'";
			}

			$html = "<input type='hidden' name='" . $value['input_name'] . "' value='" . $this->old($name) . "' {$extra} /> ";
			break;

			case "file":
			if(isset($value['type']) && $value['type'] == "multi_upload"){
				if(isset($value['count'])){
					for($i=0;$i<$value['count'];$i++){
						$html .= "<input type='file' class='form-control' name='" . $value['input_name'] . "[]'> ";
					}
				}
				
			}else{
				$html .= "<input type='file' class='form-control' name='" . $value['input_name'] . "' value='" . $this->old($name) . "'> ";
			}

			
			break;
		}

		if (!empty($value['error'])){
			$html .= "<span class='help-block'>";
			$html .=  $value['error'];
			$html .= "</span>";
		}
		if(!(isset($value['input_type']) && $value['input_type'] == "hidden")){
			$html .= "</div>";
		}

		return $html;
	}

	public function render($htmlFormat = false){
		if(isset($this->inputs)){
			if($htmlFormat){
				$html = $this->getInputToken("KeyGoesHere");
				foreach($this->inputs as $name => $value){
					$html .= $this->getElementHtml($name,$value);
				} 
				$html .= $this->getSubmitHtml($this->button);

				$formHtml = "<form role='form' method='POST' action='" . (isset($this->configs['action_path']) ? $this->configs['action_path']: "#"). "' " . (isset($this->configs['enctype']) ? "enctype='" . $this->configs['enctype']  . "'": ""). ">%s</form>";
				return sprintf($formHtml,$html);
			}else{
				return $this->inputs;
			}
		}
	}
}