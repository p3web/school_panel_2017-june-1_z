<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/11/17 AD
 * Time: 21:07
 */
//print_r($_REQUEST);exit;

require_once 'language.php';
require_once 'controller_main_function.php';
require_once 'user_profile.php';

//echo json_encode($_REQUEST);exit;
if(isset($_REQUEST['act'])) {
    switch ($_REQUEST['act']) {

        case 'lang_gender':

            switch($_REQUEST['datatype']) {
               // language::get_chart_donut_language($orgId, $deptName, $teamName);
                //{datatype: "chart", type: "a", orgId: "1", deptName: "Database", teamName: "CITeam"}\
                case 'chart' :

                    echo language::get_chart_language($_REQUEST['orgId'],$_REQUEST['deptName'],$_REQUEST['teamName'],$_REQUEST['gender']);
                    break;

                case 'table':
                    echo language::get_table_language($_REQUEST['orgId'],$_REQUEST['deptName'],$_REQUEST['teamName'],$_REQUEST['gender']);
                    break;

                case 'donut':
                    echo language::get_chart_donut_language($_REQUEST['orgId'],$_REQUEST['deptName'],$_REQUEST['teamName'],$_REQUEST['gender']);
                    break;

            }
            break;

        case 'set_staff_language':
            $valid_data = controller_main_function::check_validation(array("staffemailid", "languagename", "languagelevel"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::set_staff_language($_REQUEST["staffemailid"], $_REQUEST['languagename'], $_REQUEST['languagelevel']);
            controller_main_function::send_msg(lang::$success, lang::$message);
            break;

        case 'get_staff_language':
            $valid_data = controller_main_function::check_validation(array("staffemailid"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            $data = user_profile::get_student_language($_REQUEST['staffemailid']);
            controller_main_function::send_result($data);
            break;

        case 'delete_staff_language':
            $valid_data = controller_main_function::check_validation(array("id"));
            if (!isset($valid_data['is_valid']) || $valid_data['is_valid'] == false) {
                controller_main_function::send_msg(lang::$invalid_data, lang::$error);
            }
            user_profile::delete_staff_language($_REQUEST["id"]);
            controller_main_function::send_msg(lang::$success, lang::$message);
            break;

        default:
            echo json_encode(array("data" => false));
            break;
    }
}