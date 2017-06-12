<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/11/17 AD
 * Time: 21:07
 */
//print_r($_REQUEST);exit;

require_once 'language.php';

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
    }
}
