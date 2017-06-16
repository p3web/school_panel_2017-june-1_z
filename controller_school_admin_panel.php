<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/15/17 AD
 * Time: 14:41
 */


//____________ export data from session
/*
 * Array (
     * [admin] => 1
     * [emailid] => sukhjinder_singh009@yahoo.com
     * [user] => Array (
         * [schoolid] => 14
         * [schoolname] => Cultural Infusion
         * [adminemailid] => sukhjinder_singh009@yahoo.com
         * [firstname] => Sukhjinder
         * [lastname] => Singh
         *[resetpasswordstatus] => expired
         * [country] => India
         * [state] => Victoria
         * [city] => Melbourne
         * [suburb] => Collingwood
         * [postcode] => 3066
         * [token] => 6938f0a7fa77cd9f91bc8c388cf33f2bb3cb90a249d51139eb5f502416096664
         * [status] => active
         * [dateofregistration] =>
         * [dateofactivation] =>
     * )
 * )
 */



ob_start();
session_cache_expire();
session_start();
require_once 'controller_main_function.php';
require_once 'access_school_admin_panel.php';


if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != '' ) {

    if (isset($_REQUEST['act']) && $_REQUEST['act'] != '' && $_REQUEST['act'] != null) {

        switch ($_REQUEST['act']){

            case 'check_login':

                $data = access_school_admin_panel::get_school_by_adminemailid($_SESSION['emailid']);

                $data[0]['resetpassword'] = null;
                $data[0]['token'] = null;
                $data[0]['password'] = null;
                $data[0]['resetpasswordstatus'] = null;
                $_SESSION['user'] = $data[0];

               // print_r($_SESSION); exit;

                $result = $_SESSION['user'];

                controller_main_function::send_result($result);
                break;
            case 'get_tbl_teachers':
                $result = access_school_admin_panel::get_teacher_by_schoolId($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;
            case 'get_tbl_classes':
                $result = access_school_admin_panel::get_class_by_schoolId($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;
        }

    } else {

        header('Location: page/SchoolAdmin/index.html');
    }
}else{

    header('Location:  https://ancestryatlas.com/');
}






