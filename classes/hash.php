<?php
class Hash
{
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt); //adding randomly generated string to the created password
    }

    public static function salt(){
        //return mcrypt_create_iv($length);
        return "12as23assdfd232433X";
    }

    public static function unique(){
        return self::make(uniqid()); //making the hash
    }
}
