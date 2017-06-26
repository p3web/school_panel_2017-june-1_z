<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 3/4/17 AD
 * Time: 20:58
 */
class lang{

    public static $register_data = 'data is register';
    public static $success       = 'data success';
    public static $failed        = 'this action is failed.';
    public static $invalid_data  = 'data is not valid.';

    public static $error   = 'Error!';
    public static $message = 'Message';
    public static $empty = "Empty!";

    public static $error_duplicate_class_name = "this class name is last registered.";



    public static function error_hande($error , $display = ""){
        if($display == ""){
            return $error;
        }else{
            return $display;
        }

    }

}