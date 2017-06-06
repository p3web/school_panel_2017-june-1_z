<?php
/**
 * Created by PhpStorm.
 * User: peymanvalikhanli
 * Date: 6/6/17 AD
 * Time: 19:15
 */

require_once 'PSCO_data.php';

class invite{

    private static function check_mail_in_staff($email){
        $data = data::selects('`staff`', "`staffemailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_teamadmin($email){
        // "select teamemailid from teamadmin";
        $data = data::selects('`teamadmin`', "`teamemailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_organisationadmin($email){
        // select orgadminemailid from organisationadmin
        $data = data::selects('`organisationadmin`', "`orgadminemailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_deptadmin($email){
        //select deptemailid from deptadmin
        $data = data::selects('`deptemailid`', "`deptadmin` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_school($email){
        //select adminemailid from school
        $data = data::selects('`school`', "`adminemailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_teacher($email){
        //select teacheremailid from teacher
        $data = data::selects('`teacher`', "`teacheremailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function check_mail_in_student($email){
        //select studentemailid from student
        $data = data::selects('`student`', "`studentemailid` link '%$email%'" );

        if (count($data[0]) != 0) {
            return $data;
        } else {
            return false;
        }
    }

    private static function set_staff($email,$orgId,$deptName,$teamName,$name,$token){
       // insert into staff(staffemailid, orgid, deptname, teamname, firstname, token, status) values('$email','$orgId','$deptName','$teamName','$name','$token','pending')",$con))
        return data::insertinto("`staff`", "`staffemailid`, `orgid`, `deptname`, `teamname`, `firstname`, `token`, `status`", "'$email','$orgId','$deptName','$teamName','$name','$token','pending'");
    }

    private static function set_student($email,$schoolid,$classname,$firstname,$gender,$religion,$token){
       // insert into `student`(`studentemailid`, `schoolid`, `classname`, `firstname`, `lastname`, `gender`, `religion`, `token`, `status`)
       return data::insertinto("`student`", "`studentemailid`, `schoolid`, `classname`, `firstname`, `gender`, `religion`, `token`, `status`", "'$email', '$schoolid', '$classname', '$firstname', '$gender', '$religion', '$token','pending'");
    }

    private static function send_mail($adminid,$email,$token){

        require("/home/ancestryatlas/public_html/phpmailertesting/PHPMailer_5.2.0/class.phpmailer.php");

        $mail = new PHPMailer();

        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = "localhost";  // specify main and backup server
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "test@ancestryatlas.com";  // SMTP username
        $mail->Password = "Password456!"; // SMTP password

        $mail->From = "test@ancestryatlas.com";
        $mail->FromName = "Ancestry atlas";

        $mail->Timeout = 120;

        //to whom you want to send an email
        $mail->AddAddress($email);                  // name is optional

        // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML

        $mail->Subject = "Account Confirmation";
        include 'emailbodycontent.php';
        $ccvv = emailbodyteamadmintostaff($adminid,$email,$token);
        $mail->Body    = "".$ccvv."";
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients";
        return $mail->Send();

    }

    private static function delete_staff_by_staffemailid($email){
        return data::delete("`staff`", "staffemailid = '$email'");
    }
    private static function delete_student_by_studentemailid($email){
        return data::delete("`student`", "studentemailid = '$email'");
    }

    public static function invite_staff($orgId,$deptName,$adminid){
        $combineErr="";
        $emailErr = "";
        $email = $name = "";

        if (isset($_REQUEST['invite'])) {

            //name
            $name = test_input($_POST["name"]);



            //EMAIL VALIDATION
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
                $combineErr = $combineErr."<br>".$emailErr;
                echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $combineErr = $combineErr."<br>".$emailErr;
                    echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
                }else{



                    $dataMatched ="no";

                    $register_on_staff = invite::check_mail_in_staff(strtolower($email));
                    $register_on_teamadmin = invite::check_mail_in_teamadmin(strtolower($email));
                    $register_on_organisationadmin = invite::check_mail_in_organisationadmin(strtolower($email));
                    $register_on_deptadmin = invite::check_mail_in_deptadmin(strtolower($email));
                    $register_on_school = invite::check_mail_in_school(strtolower($email));
                    $register_on_teacher = invite::check_mail_in_teacher(strtolower($email));
                    $register_on_student = invite::check_mail_in_student(strtolower($email));

                    if(!$register_on_staff) {
                        if (!$register_on_teamadmin) {
                            if (!$register_on_organisationadmin) {
                                if (!$register_on_deptadmin) {
                                    if (!$register_on_school) {
                                        if (!$register_on_teacher) {
                                            if (!$register_on_student) {
                                                $emailErr = "Email already registered.";
                                                $combineErr = $combineErr . "<br>" . $emailErr;
                                                echo "<script type='text/javascript'>
                                            $(document).ready(function()
                                            {
                                                $('#email').css('background-color', '#ffb0b0');
                                            }); </script>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }

            //EVERTHING IS OK NOW
            if(empty($emailErr)){

                if($name == ""){
                    $name="NULL";
                }


                $teamName = $_POST['classnamedropdownstutab'];

                $bytes = openssl_random_pseudo_bytes(32);
                $token = bin2hex($bytes);


                $set_result = invite::set_staff($email,$orgId,$deptName,$teamName,$name,$token);

                if($set_result<=0){

                    die("ERROR: Data not inserted");
                }
                else{
                    $result_send_mail = invite::send_mail($adminid,$email,$token);

                    if(!$result_send_mail)
                    {
                        invite::delete_staff_by_staffemailid($email);
                        echo '<script type="text/javascript">';
                        echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
                        echo 'window.location.href = "teamadminpanel.php";';
                        echo '</script>';
                        exit;
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'alert("Email sent Successfully. Staff can check their email and fill data.");';
                        echo 'window.location.href = "teamadminpanel.php";';
                        echo '</script>';
                    }
                }

            }


        }
    }


    public static function invite_student($schoolid,$adminid){
        $combineErr="";
        $emailErr = "";
        $email = $name = "";

        if (isset($_REQUEST['invite'])) {

            //name
            $name = test_input($_POST["name"]);



            //EMAIL VALIDATION
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
                $combineErr = $combineErr."<br>".$emailErr;
                echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                    $combineErr = $combineErr."<br>".$emailErr;
                    echo "<script type='text/javascript'>
				$(document).ready(function()
				{
					$('#email').css('background-color', '#ffb0b0');
				}); </script>";
                }else{



                    $dataMatched ="no";

                    $register_on_staff = invite::check_mail_in_staff(strtolower($email));
                    $register_on_teamadmin = invite::check_mail_in_teamadmin(strtolower($email));
                    $register_on_organisationadmin = invite::check_mail_in_organisationadmin(strtolower($email));
                    $register_on_deptadmin = invite::check_mail_in_deptadmin(strtolower($email));
                    $register_on_school = invite::check_mail_in_school(strtolower($email));
                    $register_on_teacher = invite::check_mail_in_teacher(strtolower($email));
                    $register_on_student = invite::check_mail_in_student(strtolower($email));

                    if(!$register_on_staff) {
                        if (!$register_on_teamadmin) {
                            if (!$register_on_organisationadmin) {
                                if (!$register_on_deptadmin) {
                                    if (!$register_on_school) {
                                        if (!$register_on_teacher) {
                                            if (!$register_on_student) {
                                                $emailErr = "Email already registered.";
                                                $combineErr = $combineErr . "<br>" . $emailErr;
                                                echo "<script type='text/javascript'>
                                            $(document).ready(function()
                                            {
                                                $('#email').css('background-color', '#ffb0b0');
                                            }); </script>";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }

            //EVERTHING IS OK NOW
            if(empty($emailErr)){

                if($name == ""){
                    $name="NULL";
                }

                //TODO: check class name input
                $classname = $_POST['classnamedropdownstutab'];

                $bytes = openssl_random_pseudo_bytes(32);
                $token = bin2hex($bytes);

                // TODO: check data input to func (gende= null & religion= null):?
                $set_result = invite::set_student($email,$schoolid,$classname,$name,'null','null',$token);

                if($set_result<=0){

                    die("ERROR: Data not inserted");
                }
                else{
                    $result_send_mail = invite::send_mail($adminid,$email,$token);

                    if(!$result_send_mail)
                    {
                        invite::delete_student_by_studentemailid($email);
                        echo '<script type="text/javascript">';
                        echo 'alert("Email Unsuccessful. please try again. or contact us  ");' ;
                        echo 'window.location.href = "teacherpanel.php";';
                        echo '</script>';
                        exit;
                    }else{
                        echo '<script type="text/javascript">';
                        echo 'alert("Email sent Successfully. student can check their email and fill data.");';
                        echo 'window.location.href = "teacherpanel.php";';
                        echo '</script>';
                    }
                }

            }


        }
    }


}

//TODO: test function
// invite::invite_student($schoolid,$adminid);

