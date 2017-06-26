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
require_once 'invite.php';
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

            case 'get_school_profile_by_adminemailid':
                $result = access_school_admin_panel::get_school_profile_by_adminemailid($_SESSION['emailid']);
                controller_main_function::send_result($result);
                break;

            case 'edit_school_profile_by_adminemailid':
                //($schoolid,$schoolname,$adminemailid,$firstname,$lastname,$country,$state,$city,$suburb,$postcode)
                $valid_data = controller_main_function::check_validation(array("schoolid","schoolname","adminemailid","firstname","lastname","country","state","city","suburb","postcode"));

                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::edit_school_profile_by_adminemailid($_REQUEST["schoolid"],$_REQUEST["schoolname"],$_REQUEST["adminemailid"],$_REQUEST["firstname"],$_REQUEST["lastname"],$_REQUEST["country"],$_REQUEST["state"],$_REQUEST["city"],$_REQUEST["suburb"],$_REQUEST["postcode"]);
                $type = 'success';
                controller_main_function::send_msg(lang::$success, lang::$message , $type);
               // $result = array('data'=> true);
                //controller_main_function::send_result($result);
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

            case 'set_teacher_lang_bylangId':
                $valid_data = controller_main_function::check_validation(array("teacherEmailId","languagename","languagelevel"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                access_school_admin_panel::set_teacher_lang_bylangId($_REQUEST["teacherEmailId"],$_REQUEST["languagename"],$_REQUEST["languagelevel"]);
                //controller_main_function::send_msg(lang::$success, lang::$message);
                $result = array('data'=> true);
                controller_main_function::send_result($result);
                break;

            case 'get_tbl_classes':
                $result = access_school_admin_panel::get_class_by_schoolId($_SESSION['user']['schoolid']);
                controller_main_function::send_result($result);
                break;

            case 'set_class_by_schoolId':
                //set_class_by_schoolId($schoolId, $name)
                $valid_data = controller_main_function::check_validation(array("name"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
                $result =  access_school_admin_panel::set_class_by_schoolId($_SESSION['user']['schoolid'],$_REQUEST["name"]);
                controller_main_function::send_msg(lang::$success, lang::$message, "success");
//                $result = array('data'=> true);
//                controller_main_function::send_result($result);
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

            case 'get_map':
                $result = access_school_admin_panel:: get_map($_SESSION['user']['schoolid'] ,$_POST['formDoor'] );
                controller_main_function::send_result($result);
                break;

            case 'get_map_poster':

                $result = access_school_admin_panel::get_address_map_poster($_SESSION['user']['schoolid']);
                $result3 = access_school_admin_panel::get_all_student_count_map_pooster($_SESSION['user']['schoolid']);
                $result1 = access_school_admin_panel::get_gender_count_map_pooster($_SESSION['user']['schoolid'] , 'female');
                $result2 = access_school_admin_panel::get_gender_count_map_pooster($_SESSION['user']['schoolid'] , 'male');
                $export = array_merge($result, $result1);
                $export = array_merge($export, $result2);
                $export = array_merge($export, $result3);
                controller_main_function::send_result($export);
                break;

            case 'invite_teecher':
                // for invite you must set $_post['invite'] = true
                $valid_data = controller_main_function::check_validation(array("invite" , "name" , "email" , "classname"));
                if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                    controller_main_function::send_msg(lang::$invalid_data, lang::$error);
                }
               // print_r($_REQUEST);
                $result = invite::invite_teecher($_SESSION['user']['schoolid'],$_SESSION['user']['adminemailid']);
                if($result == 1 ) {
                    $result = access_school_admin_panel::set_teacher_class($_REQUEST['email'], $_SESSION['user']['schoolid'], $_REQUEST['classname']);

                    if (strpos($result, 'Duplicate') != false) {
                        access_school_admin_panel::delete_teacher_by_teacherEmailId($_REQUEST['email']);
                        $result = lang::$error_duplicate_class_name;
                        controller_main_function::send_msg($result, lang::$message);
                    }else{
                        $result = lang::$success;
                        controller_main_function::send_msg($result, lang::$message,"success");
                    }
                }

                break;

        }

    } else {

        header('Location: page/SchoolAdmin/index.html');
    }
}else{
    $result = array('data'=> false);
    controller_main_function::send_result($result);
}

