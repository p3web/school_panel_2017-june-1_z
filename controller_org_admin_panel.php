<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/21/17 AD
 * Time: 00:18
 */


ob_start();
session_cache_expire();
session_start();
require_once 'controller_main_function.php';
require_once 'access_org_key_fact.php';
require_once 'lang.php';


//if (isset($_SESSION['emailid']) && $_SESSION['emailid'] != '' ) {

    if (isset($_REQUEST['act']) && $_REQUEST['act'] != '' && $_REQUEST['act'] != null) {

        switch ($_REQUEST['act']){


            case 'get_key_fact':
                //TODO: nabi jan vodi haye function ro inja bezani mituni test koni
                echo access_org_key_fact::key_facts_to_string(1);
                break;


        }

    } else {

        header('Location: page/SchoolAdmin/index.html');
    }
/*}else{
    $result = array('data'=> false);
    controller_main_function::send_result($result);
}

*/