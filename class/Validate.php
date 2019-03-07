<?php

class Validate{

    private $_passed = false,
        $_errors = array(),
        $_db = null;

    public function __construct(){
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()){
        foreach ($items as $item => $rules){
            foreach ($rules as $rule => $rule_value) {

                $value = trim($source[$item]);
                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("This field is required", $item);
                } elseif (!empty($value)){
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("This field must be a minimum of {$rule_value} characters.", $item);
                            }
                            break;

                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("This field must be a maximum of {$rule_value} characters.", $item);
                            }
                            break;

                        case 'match':
                            if($value != $source[$rule_value]){
                                $this->addError("This field must match password", $item);
                            }
                            break;

                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()){
                                $this->addError("This email already exist.", $item);
                            }
                            break;

                        case 'email':
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                                $this->addError("This field need to be an email.", $item);
                            }
                            break;
                    }

                }
            }
        }

        if(empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error, $ext){
        $this->_errors[$ext] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }
}