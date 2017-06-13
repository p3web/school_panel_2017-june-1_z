<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/8/17 AD
 * Time: 21:37
 */
require_once 'user_profile.php';

//print_r($_REQUEST);exit;
if(isset($_REQUEST['act'])){
    switch($_REQUEST['act']){

        case 'team_user_change_pass':

            $pass = $_REQUEST['password'];
            user_profile::change_team_pass($pass, $_SESSION['teamemailidorg']);
            echo '<script type="text/javascript">';
            echo 'alert("change password successful.");' ;
            echo 'window.location.href = "teamadminpanel.php";';
            echo '</script>';
            break;

        case 'edit_team_user':
           // print_r($_REQUEST);
            foreach($_REQUEST as $key => $value){
                $exp_key = explode('_', $key);
                if($exp_key[0] == 'lang'){
                    $arr_lang[] = $value;
                    $arr_lang_id[] =$exp_key[1];
                }
            }

            foreach($_REQUEST as $key => $value){
                $exp_key = explode('_', $key);
                if($exp_key[0] == 'langlevel'){
                    $arr_lang_level[] = $value;
                }
            }

            for($i=0 ; $i<count($arr_lang);$i++){

                $lang[] = array('id'=>$arr_lang_id[$i],'lang'=>$arr_lang[$i],'level'=>$arr_lang_level[$i]);
            }
            user_profile::edit_team_language($lang);
            user_profile::edit_teame_profile($_REQUEST['email'],$_REQUEST['firstname'],$_REQUEST['lasttname'],$_REQUEST['gender'],$_REQUEST['department'],$_REQUEST['Self'],$_REQUEST['Father'],$_REQUEST['Mother'],$_REQUEST['f_Grandfather'],$_REQUEST['f_GrandMother'],$_REQUEST['m_Grandfather'],$_REQUEST['m_GrandMother']);
            user_profile::edit_age_user($_REQUEST['age'],$_REQUEST['email'],1);
            echo '<script type="text/javascript">';
            echo 'alert("Edit profile successful.");' ;
            echo 'window.location.href = "teamadminpanel.php";';
            echo '</script>';
            break;
        default :
            echo '<script type="text/javascript">';
            echo 'alert("invalid data form. act not found ");' ;
            echo 'window.location.href = "teamadminpanel.php";';
            echo '</script>';


    }
}else{
    echo '<script type="text/javascript">';
    echo 'alert("invalid data form. are you robot ?!");' ;
    echo 'window.location.href = "teamadminpanel.php";';
    echo '</script>';
}