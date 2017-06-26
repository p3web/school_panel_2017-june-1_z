<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/11/17 AD
 * Time: 21:07
 */
//print_r($_REQUEST);exit;
require_once 'lang.php';
require_once 'language.php';
require_once 'controller_main_function.php';
require_once 'user_profile.php';
require_once 'religion.php';

//echo json_encode($_REQUEST);exit;
if(isset($_REQUEST['act'])) {
    switch ($_REQUEST['act']) {

        case 'lang_gender':

            switch($_REQUEST['datatype']) {
                case 'chart' :

                    echo language::get_chart_language_teacher($_REQUEST['schoolId'],$_REQUEST['className'],$_REQUEST['gender']);
                    break;

                case 'table':
                    echo language::get_table_language_teacher($_REQUEST['schoolId'],$_REQUEST['className'],$_REQUEST['gender']);
                    break;

                case 'donut':
                    echo language::get_chart_donut_language_teacher($_REQUEST['schoolId'],$_REQUEST['className'],$_REQUEST['gender']);
                    break;
            }
            break;

        case 'set_teacher_language':
            $valid_data = controller_main_function::check_validation(array("teacheremailid", "languagename", "languagelevel"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::set_teacher_language($_REQUEST["teacheremailid"], $_REQUEST['languagename'], $_REQUEST['languagelevel']);
            //controller_main_function::send_msg(lang::$success, lang::$message , 'success');
            $data = user_profile::get_teacher_language($_REQUEST['teacheremailid']);
            controller_main_function::send_result($data);
            break;

        case 'get_teacher_language':
            $valid_data = controller_main_function::check_validation(array("teacheremailid"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            $data = user_profile::get_teacher_language($_REQUEST['teacheremailid']);
            controller_main_function::send_result($data);
            break;

        case 'delete_teacher_language':
            $valid_data = controller_main_function::check_validation(array("id","teacheremailid"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::delete_teacher_language($_REQUEST["id"]);
            //controller_main_function::send_msg(lang::$success, lang::$message);
            $data = user_profile::get_teacher_language($_REQUEST['teacheremailid']);
            controller_main_function::send_result($data);
            break;

        case 'set_student_language':
            $valid_data = controller_main_function::check_validation(array("studentemailid", "languagename", "languagelevel"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::set_student_language($_REQUEST["studentemailid"], $_REQUEST['languagename'], $_REQUEST['languagelevel']);
            controller_main_function::send_msg(lang::$success, lang::$message);
            break;

        case 'get_student_language':
            $valid_data = controller_main_function::check_validation(array("studentemailid"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            $data = user_profile::get_student_language($_REQUEST['studentemailid']);
            controller_main_function::send_result($data);
            break;

        case 'delete_student_language':
            $valid_data = controller_main_function::check_validation(array("id"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::delete_student_language($_REQUEST["id"]);
            controller_main_function::send_msg(lang::$success, lang::$message);
            break;

        case 'belief_class':

            switch($_REQUEST['datatype']) {
                case 'chart' :

                    echo religion::get_chart_religion_teacher($_REQUEST['schoolId'], $_REQUEST['className']);
                    break;

                case 'table':
                    echo religion::get_table_religion_teacher($_REQUEST['schoolId'], $_REQUEST['className']);
                    break;

                case 'donut':
                    echo religion::get_chart_donut_religion_teacher($_REQUEST['schoolId'], $_REQUEST['className']);
                    break;
            }
            break;

        case 'get_class_teacher':
            $valid_data = controller_main_function::check_validation(array("adminid","schoolId"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            $data = user_profile::get_class_by_schoolId($_REQUEST['adminid'],$_REQUEST['schoolId']);
            controller_main_function::send_result($data);
            break;

        default:
            echo json_encode(array("data" => false));
            break;
    }
}
