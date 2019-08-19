<?php
class hash{
    // this class and function is created for manual hashing for users passwords using a salt for each one as a prefix !!! and the string 
    // our salt string is genereated from salt function as a rubish string randomly generated 
    public static function make($string , $salt = ''){
        return hash('sha256',$string . $salt);
    }
    public static function salt($length){
        return mcrypt_create_iv($length);
    }
    public static function uniqueHash(){
        return self::make(uniqid());
    }
}