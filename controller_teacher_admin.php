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
    }
}
