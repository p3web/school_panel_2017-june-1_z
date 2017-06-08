<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/8/17 AD
 * Time: 13:26
 */
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
        data::update("teamadmin","`password` = '$hashAndSaltedPassword'","`teamemailid` = '$mail'");
    }

    private static function get_teame_profile($email){
        $data = data::selects('`teamadmin`', "`teamemailid` = '$email'" );

        $temp = "
                <script type='text/javascript'>
                 function btn_user_profile_edit(){
                    var btn_edit = $('#btn_profile_edit');
                    if(btn_edit.attr('name') == 'edit'){
                        $('.psco_readonly').prop('readonly', false);
                        btn_edit.html('Save');
                        btn_edit.attr('name','save');
                        $('#user_profile_header').html('Edit user profile');
                    }else{
                        $('.psco_readonly').prop('readonly', true);
                        btn_edit.html('Edit');
                        btn_edit.attr('name','edit');
                        $('#user_profile_header').html('User profile');
                    }
                 }

</script>

  <h3 id='user_profile_header'> User profile</h3>
                <hr>
                <table class='table borderless table-responsive'>
                <tr><td>Email:</td><td><input  type='email' placeholder='Email' readonly value='".$data[0]['teamemailid']."'><br></td></tr>
                <tr><td>First name:</td><td><input class='psco_readonly' type='email' placeholder='Email' readonly value='".$data[0]['firstname']."'><br></td></tr>
                <tr><td>Last name:</td><td><input class='psco_readonly' type='email' placeholder='Email' readonly value='".$data[0]['lastname']."'><br></td></tr>
                <tr><td>Gender:</td><td><select disabled >
                        <option value='male' ".($data[0]['gender']== "male"? "selected":"").">male</option>
                        <option value='female' ".($data[0]['gender']== "female"? "selected":"").">female</option>
                    </select><br></td></tr>
                <tr><td>Password:</td><td><button id='btn_change_pass_user' type='button' class='btn btn-warning' >change</button><br></td></tr>
                <tr><td>Department:</td><td> <select disabled>
                        <option value='Database' ".($data[0]['deptname']== "Database"? "selected":"").">Database</option>
                        <option value='HR' ".($data[0]['deptname']== "HR"? "selected":"").">HR</option>
                        <option value='IT' ".($data[0]['deptname']== "IT"? "selected":"").">IT</option>
                    </select></td></tr>
                </table>
                <br><hr>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                <button id='btn_profile_edit' name='edit' type='button' class='btn btn-warning' onclick='btn_user_profile_edit()'>Edit</button>

                <script>
	            $(document).ready(function(){
		            $('#btn_change_pass_user').click(function(){
			            $('#modal_change_pass_user').modal('show');
		            });
	            });
        </script>

                ";
        return $temp;

    }



}
