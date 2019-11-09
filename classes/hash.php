<?php
class Hash
{
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt); //adding randomly generated string to the created password
    }

    public static function salt($length){
        //return mcrypt_create_iv($length);
        return uniqid('', true);
    }

    public static function unique(){
        return self::make(uniqid()); //making the hash
    }
}
