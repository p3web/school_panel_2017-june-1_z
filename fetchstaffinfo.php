<?php
 require_once 'user_profile.php';
 $connect = mysqli_connect("localhost", "ancestry_atlas", "]?7W%4yATmA?", "ancestry_atlas");
 if(isset($_POST["employee_id"]))  
 {  
     
     $arr= array();
    
    
    
    
     
      $query = "SELECT * FROM staff WHERE staffemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $rows = mysqli_fetch_array($result);  
        
      
      $query = "SELECT * FROM staffbirthdetails WHERE staffemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      
          
      $query = "SELECT * FROM stafflanguage WHERE staffemailid = '".$_POST["employee_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $rowss = mysqli_fetch_array($result);


     $language = user_profile::get_staff_language($_POST["employee_id"]);

     $age = user_profile::get_age_user($_POST["employee_id"],2);

     $temp="";
     for($lang_index=0; $lang_index<count($language);$lang_index++){
         $temp .="<tr><td><select id='edit_employee_language$lang_index' name='lang_".$language[$lang_index]['id']."' class='PSCO_employee_language form-control' data-placeholder='Choose a Language...' form='update_form' ></select></td><td><select id='edit_employee_language_level$lang_index' name='langlevel_".$language[$lang_index]['id']."' class='PSCO_employee_language_level form-control' data-placeholder='Choose a Language level...' form='update_form'></select><br></td></tr>";
     }
     $temp .="<script type='text/javascript'>
 $('.PSCO_employee_language').ready(function(){
                    $('.PSCO_employee_language').load( 'page/data_value/lanuage.html' );
                });
                $('.PSCO_employee_language_level').ready(function(){
                    $('.PSCO_employee_language_level').load( 'page/data_value/lanuage_level.html' );
                });
                setTimeout(function(){
                $('#age').val('" . $age[0]['age'] . "');

";
     for($lang_index=0; $lang_index<count($language);$lang_index++){
         $temp .="
                $('#edit_employee_language$lang_index').val('".$language[$lang_index]['languagename']."');
                $('#edit_employee_language_level$lang_index').val('".$language[$lang_index]['languagelevel']."');
                ";
     }
     $temp .="}, 1000);
                </script>";

     $row_lang  = array('data'=>$temp);
      
      
       $arr['arr1'] = $rows;
       $arr['arr2'] = $row;
       $arr['arr3'] = $rowss;
       $arr['arr4'] = $row_lang;



        
       echo json_encode($arr);


 }  
 ?>