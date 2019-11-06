<!-- will be used to check if validations passed  -->
<!-- should be reuseable -->
<?php
	class Validate {
		private $_passed = false,
				$_errors = array(),
				$_db = null;

			public function __construct(){
				$this->_db = DB::getInstance();
			}

			public function check($source, $items = array()){
				foreach ($items as $item => $rules) {
					foreach ($rules as $rule => $rule_value) {
						$value = $source[$item];

						$value = trim($source[$item]);
						$item = escape($item);
						if ($rule === 'required' && empty($value)){
							$this->addError("{$item} is required");
						}elseif(!empty($value)){
							switch ($rule) {
								case 'min':
									if (strlen($value) < $rule_value){
										$this->addError("{$item} must be a minimum of {$rule_value} charactors.");
									}
								break;
								case 'max':
									if (strlen($value) > $rule_value){
										$this->addError("{$item} must be a Maximum of {$rule_value} charactors.");
									}
								break;
								case 'matches':
									if ($value != $source[$rule_value]){
										$this->addError("{$rule_value} must match {$item}");
									}
								break;
								case 'unique':
									$check = $this->_db->get($rule_value, array($item, '=', $value));
									if ($check->count()){
										$this->addError("{$item} already exists.");
									}
								break;
								default:
									# code...
									break;
							}
					}
						//echo "{$item} {$rule} must be {$rule_value}<br>";
				}
			}
			if (empty($this->_errors)){
				$this->_passed = true;
			}
			return $this;
		}

		private function addError($error){
			$this->_errors[] =  $error;
		}

		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}
	}
?>