<?php 

class validation{
    private $_passed = false,
            $_errors = array() ,
            $_db = null ;

    public function __construct(){
        $this->_db = database::getInstance();
    }
    public function check($source,$items = array () ){
        foreach($items as $item => $rules ){ // $item is going to be as example 'username' and $rules is going to be the array of checkers we defiened 
            // we are going to do the same with rule valus 
            foreach ( $rules as $rule => $rule_value){
                // echo "{$item} {$rule} must be {$rule_value} <br>";
                $value = trim($source[$item]); // used trim to remove white spaces 
                $item = escape($item); // sanitizing 
                if( $rule === 'required' && empty($value)){
                    $this->addError("{$item} is required");
                }else if ( !empty($value)){
                    switch ($rule){
                        case 'min':
                            if (strlen($value) < $rule_value ){
                                $this->addError("{$item} cant be less that {$rule_value}");
                            }
                        break;
                        case 'max':
                            if (strlen($value) > $rule_value ){
                                $this->addError("{$item} cant be greater than {$rule_value}");
                            }
                        break;
                        case 'matches':
                            if( $value != $source[$rule_value]){
                                $this->addError("{$item} Must Be Matching With  {$rule_value}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value , array($item , '=' , $value ));
                            if($check->count()){
                                $this->addError("{$item} already exists ");
                            }
                        break;

                    }
                }
            }
        }
        if(empty($this->_errors)){
            $this->_passed = true ;
        }
        return $this;
    }
    private function addError($error){
        $this->_errors[] = $error;
    }
    public function errors(){
        return $this->_errors;
    }
    public function passed(){
        return $this->_passed;
    }
}