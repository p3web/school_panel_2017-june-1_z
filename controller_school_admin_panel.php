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
require_once 'access_school_key_fact.php';
require_once 'lang.php';


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

                $result = $_SESSION['user'];

                controller_main_function::send_result($result);
                break;

            case 'get_tbl_teachers':
                $result = access_school_admin_panel::get_teacher_by_schoolId($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;

            case 'get_teacher_by_teacheremailid':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result = access_school_admin_panel::get_teacher_by_teacheremailid($_REQUEST["teacheremailid"]);
                controller_main_function::send_result($result);
                break;

            case 'get_teacher_lang_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result= access_school_admin_panel::get_teacher_lang_by_teacherEmailId($_REQUEST["teacheremailid"]);
                controller_main_function::send_result($result);
                break;

            case 'get_teacher_birthDetails_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result = access_school_admin_panel::get_teacher_birthDetails_by_teacherEmailId($_REQUEST["teacheremailid"]);
                controller_main_function::send_result($result);
                break;

            case 'delete_teacher_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::delete_teacher_by_teacherEmailId($_REQUEST["teacheremailid"]);
                controller_main_function::send_msg(lang::$success, lang::$message);
                break;

            case 'delete_teacher_birthDetails_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::delete_teacher_birthDetails_by_teacherEmailId($_REQUEST["teacheremailid"]);
                controller_main_function::send_msg(lang::$success, lang::$message);
                break;

            case 'delete_teacher_lang_by_langID':
                $valid_data = controller_main_function::check_validation(array("id"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::delete_teacher_lang_by_langID($_REQUEST["id"]);
                controller_main_function::send_msg(lang::$success, lang::$message);
                break;

            case 'edit_teacher_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid","firstname","lastname","gender","religion"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_teacher_by_teacherEmailId($_REQUEST["teacheremailid"],$_REQUEST["firstname"],$_REQUEST["lastname"],$_REQUEST["gender"],$_REQUEST["religion"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
                $result = array('data'=> true);
                controller_main_function::send_result($result);
                break;

            case 'edit_teacher_birthDetails_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid","birthplace","fatherbirthplace","motherbirthplace","fatherfatherbirthplace","fathermotherbirthplace","motherfatherbirthplace","mothermotherbirthplace"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_teacher_birthDetails_by_teacherEmailId($_REQUEST["teacheremailid"],$_REQUEST["birthplace"],$_REQUEST["fatherbirthplace"],$_REQUEST["motherbirthplace"],$_REQUEST["fatherfatherbirthplace"],$_REQUEST["fathermotherbirthplace"],$_REQUEST["motherfatherbirthplace"],$_REQUEST["mothermotherbirthplace"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
               $result = array('data'=> true);
               controller_main_function::send_result($result);
                break;

            case 'edit_teacher_lang_bylangId':
                $valid_data = controller_main_function::check_validation(array("id","languagename","languagelevel"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_teacher_lang_bylangId($_REQUEST["id"],$_REQUEST["languagename"],$_REQUEST["languagelevel"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
                $result = array('data'=> true);
                controller_main_function::send_result($result);
                break;

            case 'edit_class_by_schoolId':
                $valid_data = controller_main_function::check_validation(array("current_name","name"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_class_by_schoolId($_SESSION['user']['schoolid'],$_REQUEST["current_name"],$_REQUEST["name"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
                $result = array('data'=> true);
                controller_main_function::send_result($result);
                break;

            case 'get_tbl_classes':
                $result = access_school_admin_panel::get_class_by_schoolId($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;

            case 'get_key_fact':
                echo access_school_key_fact::key_facts_to_string($_SESSION['user']['schoolid'],'S1');
                break;

            case 'get_key_fact_json':
                $result = array("data" =>  access_school_key_fact::key_facts_to_string($_SESSION['user']['schoolid'],'S1'));
                controller_main_function::send_result($result);
                break;

            case 'get_religions':
                $result = access_school_admin_panel::get_religions($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;

            case 'get_languge_by_gender':
                $valid_data = controller_main_function::check_validation(array("gender"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result = access_school_admin_panel::get_languge_by_gender($_SESSION['user']['schoolid'],$_REQUEST["gender"]);
                controller_main_function::send_result($result);
                break;

            case 'get_teacher_age_group_by_teacherEmailId':
                $valid_data = controller_main_function::check_validation(array("teacheremailid"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result = access_school_admin_panel::get_teacher_age_group_by_teacherEmailId($_REQUEST["teacheremailid"]);
                controller_main_function::send_result($result);
                break;
            case 'edit_teacher_age_group_by_id':
                $valid_data = controller_main_function::check_validation(array("id","age"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_teacher_age_group_by_id($_REQUEST["id"],$_REQUEST["age"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
                $result = array('data'=> true);
                controller_main_function::send_result($result);

                break;

        }

    } else {

        header('Location: page/SchoolAdmin/index.html');
    }
}else{
    $result = array('data'=> false);
    controller_main_function::send_result($result);
}

