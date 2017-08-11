<?php
namespace Blab\Libs;

use Blab\Mvc\Models\Blab_Model;

class Input extends Blab_Model
{

		private $_errors = array(),
				$_passed = false;

		public function __construct(){

			// Call Parent __construct for instantiat Database

			parent::__construct();

		}

		public function check($source,$items=array()){

			foreach ($items as $item => $rules) {

				foreach ($rules as $rule => $rule_value) {
					
					$value = $source[$item];


					if ($rule==='required' && empty($value)) {

							$this->addError("{$item} is required");

					}else if(!empty($value)){
						
						switch ($rule) {

							case 'min':

								if (strlen($value)<$rule_value) {
									
									$this->addError("{$item} must be minimum {$rule_value} charecters .");
								}

								break;

							case 'max':
								

								if (strlen($value)>$rule_value) {
									
									$this->addError("{$item} must be maximum {$rule_value} charecters .");
								}

								break;
							case 'preg_match':
								
									if (!preg_match('/^.(?=.{8,})(?=.[a-z])(?=.[A-Z])(?=.[\d\W]).*$/',$value)) {

										if (!preg_match('/(?=.*[A-Z])/',$value)) {

											$this->addError("{$item} MUST BE CONTAIN AT LEAST 1 CAPITAL LETTER.");

										}else if (!preg_match('/(?=.*[\d])/',$value)) {

											$this->addError("{$item} MUST BE CONTAIN AT LEAST  1 NUMBER .");
										}else if (!preg_match('/(?=.*[a-z])/',$value)) {

											$this->addError("{$item} MUST BE CONTAIN AT LEAST  1 SMALL LETTER .");
										}else if (!preg_match('/(?=.*[\W])/',$value)) {

											$this->addError("{$item} MUST BE CONTAIN AT LEAST 1 SPECIAL CHARECTER.");
										}

									}

								break;

							case 'matches':
								
								if ($value != $source[$rule_value]) {
									
									$this->addError("{$item} must be same as {$rule_value}.");
								}

								break;

							case 'email' :

									$email = $source[$rule];
									
									if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

										$this->addError("{$email} doesn't Valid.");
									}

									$emailName = strstr($email, '@',true);
									$userName  = $source[$rule_value];

									if ($userName==$emailName) {
										
										$this->addError("{$rule} Name and {$rule_value} doesn't same.");
									}

								break;

							case 'unique':

								// if ($this->_db->query()->exists($rule_value,array($item, '=',$value))) {
									
								// 	$this->addError("{$item} already exists.");
								// }

							$exists = $this->_db->query()
									->from($rule_value)
									->where(array('id'=>self::get('id')),'<>')
									->andwhere(array($item=>$value),'=')
									->results();

								if ($exists) {
									
									$this->addError("{$item} already exists.");
								}

								break;
							
						}
					}

				}
			}

			if (empty($this->_errors)) {
				
				$this->_passed = true;
			}

			return $this;
		}

		private function addError($error){

			$this->_errors[]=$error;
		}

		public function errors(){

			return $this->_errors;
		}

		public function passed(){

			return $this->_passed;
		}

		public static function exists($type='post'){

			switch ($type) {

				case 'post':
					
					return (!empty($_POST)) ? true : false;

					break;

				case 'get':
					
					return (!empty($_GET)) ? true : false;

					break;
				
				default:
					
					return false;

					break;
			}
		}

		public static function get($item){

			if (isset($_POST[$item])) {
				
				return htmlentities($_POST[$item]);
			}else if (isset($_GET[$item])) {
				
				return htmlentities($_GET[$item]);
			}
			return '';
		}
}