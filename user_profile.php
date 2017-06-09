<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/8/17 AD
 * Time: 13:26
 */

ob_start();
session_cache_expire();
session_start();

require_once 'PSCO_data.php';

class user_profile
{

    public static function get_profile($id,$type = "teamadmin"){

        switch($type){

            case "teamadmin":
                return self::get_teame_profile($id);
                break;

        }

    }

    public static function change_team_pass($pass,$mail){

        $hashAndSaltedPassword = password_hash($pass, PASSWORD_BCRYPT);
        data::update("`teamadmin`","`password` = '$hashAndSaltedPassword'","`teamadmin`.`teamemailid` = '$mail'");

    }

    public static function edit_teame_profile($email,$firstname,$lasttname,$gender,$department,$birthplace, $fatherbirthplace, $motherbirthplace, $fatherfatherbirthplace, $fathermotherbirthplace, $motherfatherbirthplace, $mothermotherbirthplace){

        data::update("`teamadmin`","`deptname`='$department',`firstname`='$firstname',`lastname`='$lasttname', `gender`='$gender'","`teamemailid`='$email'");

        data::update("`teamadminbirthdetails`","`birthplace`='$birthplace', `fatherbirthplace`='$fatherbirthplace', `motherbirthplace`='$motherbirthplace', `fatherfatherbirthplace`='$fatherfatherbirthplace', `fathermotherbirthplace`='$fathermotherbirthplace', `motherfatherbirthplace`='$motherfatherbirthplace', `mothermotherbirthplace`='$mothermotherbirthplace'","`teamemailid`='$email'");
    }

    public static function edit_team_language($data){

        for($index=0 ; $index<count($data);$index++) {
            data::update("teamadmin_language", "`languagename`= '" . $data[$index]['lang'] . "' ,`languagelevel`= '" . $data[$index]['level'] . "'", "`id`= " . $data[$index]['id']);
        }
    }

    private static function get_teame_profile($email){
        $data = data::selects('`teamadmin`', "`teamemailid` = '$email'" );

        $language = data::selects("`teamadmin_language`","`teamemailid` = '$email'");
        $birthdetails = data::selects("`teamadminbirthdetails`","`teamadminbirthdetails`.`teamemailid` = '$email'");

        //print_r($language);exit;
        $temp = "
            <script type='text/javascript'>
                function btn_user_profile_edit(){
                    var btn_edit = $('#btn_profile_edit');
                    if(btn_edit.attr('name') == 'edit'){
                        $('.psco_readonly').prop('readonly', false);
                        $('#frm_edit_user_gender').prop('disabled', false);
                        $('#frm_edit_user_department').prop('disabled', false);
                        $('#frm_edit_user_religion').prop('disabled', false);
                        $('.PSCO_country').prop('disabled', false);
                        $('.PSCO_language').prop('disabled', false);
                        $('.PSCO_language_level').prop('disabled', false);
                        btn_edit.html('Save');
                        btn_edit.attr('name','save');
                        $('#user_profile_header').html('Edit user profile');
                    }else{
                        $('#frm_edit_user').submit();
                        $('.psco_readonly').prop('readonly', true);
                        $('#frm_edit_user_gender').prop('disabled', true);
                        $('#frm_edit_user_department').prop('disabled', true);
                        $('#frm_edit_user_religion').prop('disabled', true);
                        $('.PSCO_country').prop('disabled', true);
                        $('.PSCO_language').prop('disabled', true);
                        $('.PSCO_language_level').prop('disabled', true);
                        btn_edit.html('Edit');
                        btn_edit.attr('name','edit');
                        $('#user_profile_header').html('User profile');
                    }
                }

            </script>

            <h3 id='user_profile_header' style='text-align: center;'> User profile</h3>
            <img src='images/mainlogo.png' width='73' height='73' class='loglogo' style='margin: 0 auto;display: block;'>
            <hr>
            <form id='frm_edit_user' method='post' style='margin: 0 auto;display: block;' action='controller_user.php'>
            <h3>PERSONAL DETAILS</h3>
                <table class='table borderless table-responsive'>
                    <tr><td>Email:</td><td><input name='email' class='form-control'  type='email' placeholder='Email' readonly value='".$data[0]['teamemailid']."'><br></td></tr>
                    <tr><td>First name:</td><td><input name='firstname' class='psco_readonly form-control' type='email' placeholder='Email' readonly value='".$data[0]['firstname']."'><br></td></tr>
                    <tr><td>Last name:</td><td><input name='lasttname' class='psco_readonly form-control' type='email' placeholder='Email' readonly value='".$data[0]['lastname']."'><br></td></tr>
                    <tr><td>Gender:</td><td><select name='gender' id='frm_edit_user_gender' class='form-control' form='frm_edit_user' disabled >
                        <option value='male' ".($data[0]['gender']== "male"? "selected":"").">male</option>
                        <option value='female' ".($data[0]['gender']== "female"? "selected":"").">female</option>
                    </select><br></td></tr>
                    <tr><td>Department:</td><td> <select name='department' class='form-control' id='frm_edit_user_department' form='frm_edit_user' disabled>
                        <option value='Database' ".($data[0]['deptname']== "Database"? "selected":"").">Database</option>
                        <option value='HR' ".($data[0]['deptname']== "HR"? "selected":"").">HR</option>
                        <option value='IT' ".($data[0]['deptname']== "IT"? "selected":"").">IT</option>
                    </select><br></td></tr>
                    <tr><td>Religion:</td><td> <select name='religion' class='form-control' id='frm_edit_user_religion' form='frm_edit_user' disabled>
                        <option value='Database' ".($data[0]['religion']== "Buddhism"? "selected":"").">Buddhism</option>
                        <option value='HR' ".($data[0]['religion']== "Christianity"? "selected":"").">Christianity</option>
                        <option value='IT' ".($data[0]['religion']== "hindu"? "selected":"").">hindu</option>
                        <option value='IT' ".($data[0]['religion']== "Islam"? "selected":"").">Islam</option>
                        <option value='IT' ".($data[0]['religion']== "Nation Of Islam"? "selected":"").">Nation Of Islam</option>
                        <option value='IT' ".($data[0]['religion']== "Pluralist"? "selected":"").">Pluralist</option>
                        <option value='IT' ".($data[0]['religion']== "Sikhism"? "selected":"").">Sikhism</option>
                    </select><br></td></tr>
                    <tr><td>Password:</td><td><button id='btn_change_pass_user' type='button' class='btn btn-warning' style='margin: 0 auto;display: block;width: 45%;padding: 2%;' >Update My Password</button><br></td></tr>
                </table>
                <br><hr>
                <h3>BIRTH COUNTRIES</h3>
                <table class='table borderless table-responsive'>
                    <tr><td>Self:</td><td><select id='profile_country_self' name='Self' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><hr></td></tr>
                    <tr><td>Mother:</td><td><select id='profile_country_Mother' name='Mother' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><br></td></tr>
                    <tr><td>Grandfather:</td><td><select id='profile_country_Mother_Grandfather' name='m_Grandfather' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><br></td></tr>
                    <tr><td>GrandMother:</td><td><select id='profile_country_Mother_GrandMother' name='m_GrandMother' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><hr></td></tr>
                    <tr><td>Father:</td><td><select id='profile_country_Father' name='Father' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><br></td></tr>
                    <tr><td>Grandfather:</td><td><select id='profile_country_Father_Grandfather' name='f_Grandfather' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><br></td></tr>
                    <tr><td>GrandMother:</td><td><select id='profile_country_Father_GrandMother' name='f_GrandMother' class='PSCO_country form-control' data-placeholder='Choose a country...' disabled></select><br></td></tr>
                </table>
                <br><hr>
                <h3>LANGUAGES</h3>
                <table class='table borderless table-responsive'>";
                for($lang_index=0; $lang_index<count($language);$lang_index++){
                    $temp .="<tr><td><select id='edit_profile_language$lang_index' name='lang_".$language[$lang_index]['id']."' class='PSCO_language form-control' data-placeholder='Choose a Language...' form='frm_edit_user'  disabled></select></td><td><select id='edit_profile_language_level$lang_index' name='langlevel_".$language[$lang_index]['id']."' class='PSCO_language_level form-control' data-placeholder='Choose a Language level...' form='frm_edit_user' disabled></select><br></td></tr>";
                }

        $temp .="</table>
                <br><hr>
                <button type='button' class='btn btn-danger'  data-dismiss='modal'>Close</button>
                <input type='hidden' name='act' value='edit_team_user'>
                <button id='btn_profile_edit' name='edit' type='button' class='btn btn-warning' onclick='btn_user_profile_edit()'>Edit</button>
            </form>
            <script type='text/javascript'>
                $('.PSCO_country').ready(function(){
                    $('.PSCO_country').load( 'page/data_value/country.html' );
                });
                $('.PSCO_language').ready(function(){
                    $('.PSCO_language').load( 'page/data_value/lanuage.html' );
                });
                $('.PSCO_language_level').ready(function(){
                    $('.PSCO_language_level').load( 'page/data_value/lanuage_level.html' );
                });
                $(document).ready(function(){
                    $('#btn_change_pass_user').click(function(){
                        $('#modal_change_pass_user').modal('show');
                    });
                });

                setTimeout(function(){
                ";

        for($lang_index=0; $lang_index<count($language);$lang_index++){
            $temp .="
                $('#edit_profile_language$lang_index').val('".$language[$lang_index]['languagename']."');
                $('#edit_profile_language_level$lang_index').val('".$language[$lang_index]['languagelevel']."');
                ";
        }

        $temp .="
                $('#profile_country_self').val('".$birthdetails[0]['birthplace']."');
                $('#profile_country_Mother').val('".$birthdetails[0]['motherbirthplace']."');
                $('#profile_country_Mother_Grandfather').val('".$birthdetails[0]['fathermotherbirthplace']."');
                $('#profile_country_Mother_GrandMother').val('".$birthdetails[0]['mothermotherbirthplace']."');
                $('#profile_country_Father').val('".$birthdetails[0]['fatherbirthplace']."');
                $('#profile_country_Father_Grandfather').val('".$birthdetails[0]['fatherfatherbirthplace']."');
                $('#profile_country_Father_GrandMother').val('".$birthdetails[0]['motherfatherbirthplace']."');

                }, 3000);
                </script>";

        return $temp;

    }



}




