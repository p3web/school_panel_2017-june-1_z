<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/8/17 AD
 * Time: 21:37
 */
require_once 'user_profile.php';
if(isset($_REQUEST['act'])){
    switch($_REQUEST['act']){

        case'team_user_change_pass':
            $pass = $_REQUEST['password'];
            user_profile::change_team_pass($pass, $_SESSION['teamemailidorg']);
            echo '<script type="text/javascript">';
            echo 'alert("change password successful.");' ;
            echo 'window.location.href = "teamadminpanel.php";';
            echo '</script>';
            break;


    }
}